<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Custom;
use App\Models\Product;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    //
    public function index()
    {
        $carts = Cart::with(['customer', 'items.product'])
                   ->orderBy('created_at', 'desc')
                   ->paginate(10);

        return view('carts.index', compact('carts'));
    }

    public function show($cartId)
    {
        $cart = Cart::with(['customer', 'items.product'])
                  ->findOrFail($cartId);

        $total = $cart->items->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('carts.show', compact('cart', 'total'));
    }


    public function create()
    {
        $users = Custom::all();
        $products = Product::all(); // جلب جميع المنتجات
        return view('carts.create', compact('users', 'products'));
    }

    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:customs,UserId',
        'products' => 'required|array|min:1',
        'products.*.product_id' => 'required|exists:products,productId',
        'products.*.quantity' => 'required|integer|min:1'
    ]);

    // بدء المعاملة لضمان سلامة البيانات
    DB::beginTransaction();

    try {
        // التحقق من عدم وجود سلة نشطة للمستخدم
        if (Cart::where('UserId', $request->user_id)->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'المستخدم لديه سلة تسوق نشطة بالفعل');
        }

        // إنشاء السلة
        $cart = Cart::create(['UserId' => $request->user_id]);

        // إضافة المنتجات للسلة
        foreach ($request->products as $product) {
            $cart->items()->create([
                'product_id' => $product['product_id'],
                'quantity' => $product['quantity']
            ]);
        }

        DB::commit();

        return redirect()->route('carts.index', $cart->cartId)
            ->with('success', 'تم إنشاء سلة التسوق بنجاح مع إضافة المنتجات');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()
            ->withInput()
            ->with('error', 'حدث خطأ أثناء إنشاء السلة: ' . $e->getMessage());
    }
}


    /// دالة التعديل
    public function edit($cartId)
    {
        $cart = Cart::with(['customer', 'items.product'])->findOrFail($cartId);
        $products = Product::all();
        return view('carts.edit', compact('cart', 'products'));
    }

    public function update(Request $request, $cartId)
    {
        $request->validate([
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,productId',
            'products.*.quantity' => 'required|integer|min:1'
        ]);

        DB::beginTransaction();

        try {
            $cart = Cart::findOrFail($cartId);
            $existingItems = $cart->items->keyBy('cart_item_id');

            foreach ($request->products as $productData) {
                if (isset($productData['_remove'])) {
                    if (isset($productData['id'])) {
                        $existingItems[$productData['id']]->delete();
                    }
                    continue;
                }

                if (isset($productData['id'])) {
                    $existingItems[$productData['id']]->update([
                        'product_id' => $productData['product_id'],
                        'quantity' => $productData['quantity']
                    ]);
                } else {
                    $cart->items()->create([
                        'product_id' => $productData['product_id'],
                        'quantity' => $productData['quantity']
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('carts.index', $cart->cartId)
                   ->with('success', 'تم تحديث سلة التسوق بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                   ->withInput()
                   ->with('error', 'حدث خطأ أثناء التحديث: ' . $e->getMessage());
        }
    }

// دالة الحذف
public function destroy($cartId)
{
    $cart = Cart::findOrFail($cartId);

    // حذف جميع العناصر أولاً
    $cart->items()->delete();

    // ثم حذف السلة
    $cart->delete();

    return redirect()->route('carts.index')
           ->with('success', 'تم حذف سلة التسوق بنجاح');
}
}
