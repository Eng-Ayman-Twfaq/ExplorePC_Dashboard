<?php

namespace App\Http\Controllers;

use App\Models\Custom;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // تحميل العلاقات المطلوبة مع الطلبات
        $query = Order::with([
            'customer',
            'items',
            'items.product' => function($query) {
                $query->select('productId', 'name', 'price', 'image');
            }
        ]);

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            $status = urldecode($request->status);
            $query->where('status', $status);
        }

        // فلترة حسب التاريخ
        if ($request->filled('date')) {
            $query->whereDate('orderDate', $request->date);
        }

        // فلترة حسب العميل (إذا أردت إضافتها)
        if ($request->filled('customer_id')) {
            $query->where('UserId', $request->customer_id);
        }

        // فلترة حسب المنتج (من خلال عناصر الطلب)
        if ($request->filled('product_id')) {
            $query->whereHas('items', function($q) use ($request) {
                $q->where('productId', $request->product_id);
            });
        }

        // ترتيب النتائج وتقسيمها
        $orders = $query->latest('orderDate')->paginate(10);

        // بيانات إضافية للعرض
        $customers = Custom::select('UserId', 'UserName')->get();
        $products = Product::select('productId', 'name')->get();

        return view('orders.index', [
            'orders' => $orders,
            'statuses' => ['قيد الانتظار', 'قيد المعالجة', 'مكتمل', 'ملغى'],
            'customers' => $customers,
            'products' => $products,
            'filters' => $request->only(['status', 'date', 'customer_id', 'product_id'])
        ]);
    }

    public function create()
    {
        $customers = Custom::all();
        $products = Product::all();
        return view('orders.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'UserId' => 'required|exists:customs,UserId',
            'orderDate' => 'required|date',
            'shippingAddress' => 'required|string|max:255',
            'status' => 'required|in:قيد الانتظار,قيد المعالجة,مكتمل,ملغى',
            'products' => 'required|array|min:1',
            'products.*.productId' => 'required|exists:products,productId',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0'
        ]);

        // بدء transaction لضمان سلامة البيانات
        DB::beginTransaction();

        try {
            // إنشاء الطلب
            $order = Order::create([
                'UserId' => $validated['UserId'],
                'orderDate' => $validated['orderDate'],
                'shippingAddress' => $validated['shippingAddress'],
                'status' => $validated['status'],
                'totalAmount' => 0 // سيتم حسابه لاحقاً
            ]);

            // إضافة عناصر الطلب
            $totalAmount = 0;
            foreach ($request->products as $product) {
                $orderItem = $order->items()->create([
                    'productId' => $product['productId'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price']
                ]);

                $totalAmount += $product['quantity'] * $product['price'];
            }

            // تحديث المجموع الكلي للطلب
            $order->update(['totalAmount' => $totalAmount]);

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'تم إنشاء الطلب بنجاح');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'حدث خطأ أثناء إنشاء الطلب: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function edit($orderId)
{
    $order = Order::with(['customer', 'items.product'])
                ->findOrFail($orderId);

    $customers = Custom::all();
    $products = Product::all();

    return view('orders.edit', compact('order', 'customers', 'products'));
}

public function update(Request $request, $orderId)
{
    // 1. التحقق من البيانات
    $validated = $request->validate([
        'UserId' => 'required|exists:customs,UserId',
        'orderDate' => 'required|date',
        'shippingAddress' => 'required|string|max:255',
        'status' => 'required|in:قيد الانتظار,قيد المعالجة,مكتمل,ملغى',
        'products' => 'required|array|min:1',
        'products.*.productId' => 'required|exists:products,productId',
        'products.*.quantity' => 'required|integer|min:1',
        'products.*.price' => 'required|numeric|min:0'
    ]);

    DB::beginTransaction();

    try {
        // 2. جلب الطلب المطلوب
        $order = Order::findOrFail($orderId);

        // 3. تحديث بيانات الطلب الأساسية
        $order->update([
            'UserId' => $validated['UserId'],
            'orderDate' => $validated['orderDate'],
            'shippingAddress' => $validated['shippingAddress'],
            'status' => $validated['status']
        ]);

        // 4. معالجة المنتجات
        $order->items()->delete(); // حذف القديم أولاً

        $totalAmount = 0;
        foreach ($request->products as $product) {
            $order->items()->create([
                'productId' => $product['productId'],
                'quantity' => $product['quantity'],
                'price' => $product['price']
            ]);
            $totalAmount += $product['quantity'] * $product['price'];
        }

        // 5. تحديث المجموع الكلي
        $order->update(['totalAmount' => $totalAmount]);

        DB::commit();

        // 6. إعادة التوجيه مع رسالة نجاح
        return redirect()->route('orders.index', $order->orderId)
                        ->with('success', 'تم تحديث الطلب بنجاح');

    } catch (\Exception $e) {
        DB::rollBack();
        // 7. إرجاع الخطأ مع البيانات القديمة
        return back()->withInput()
                    ->with('error', 'حدث خطأ: ' . $e->getMessage());
    }
}

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'تم حذف الطلب بنجاح');
    }
}
