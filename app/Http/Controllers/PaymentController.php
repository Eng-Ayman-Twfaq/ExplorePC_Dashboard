<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    //
   /**
     * عرض قائمة الدفعات مع الفلترة
     */
   // دالة لعرض الدفعات مع الفلترة
   public function index(Request $request)
   {
       // تعريف قيم الاختيارات للفلترة
       $paymentMethods = [
           'wallet' => 'محفظة جوالي',
           'kareemy' => 'محفظة جيب الكريمي',
           'bank_transfer' => 'تحويل بنكي',
           'cash' => 'نقداً'
       ];

       $statuses = [
           'paid' => 'مدفوع',
           'pending' => 'قيد الانتظار',
           'failed' => 'فشل الدفع',
           'refunded' => 'تم الاسترجاع'
       ];

       // بدء بناء الاستعلام
       $query = Payment::query();

       // فلترة بحالة الدفع (إذا كانت موجودة وغير فارغة)
       if ($request->filled('status')) {
           $query->where('status', $request->status);
       }

       // فلترة بطريقة الدفع (إذا كانت موجودة وغير فارغة)
       if ($request->filled('payment_method')) {
           $query->where('paymentMethod', $request->payment_method);
       }

       // فلترة برقم الطلب (إذا كان موجوداً وغير فارغ)
       if ($request->filled('order_id')) {
           $query->where('orderId', $request->order_id);
       }

       // فلترة بتاريخ الدفع (إذا كان موجوداً وغير فارغ)
       if ($request->filled('date')) {
           $query->whereDate('paymentDate', $request->date);
       }

       // تطبيق الترقيم مع الاحتفاظ بمعايير الفلترة
       $payments = $query->latest('paymentDate')
                        ->paginate(10)
                        ->appends($request->query());

       return view('payments.index', [
           'payments' => $payments,
           'paymentMethods' => $paymentMethods,
           'statuses' => $statuses,
           'filters' => $request->all() // لإظهار القيم المفلترة في النموذج
       ]);
   }

    /**
     * عرض نموذج إنشاء دفعة جديدة
     */
    public function create()
    {
        $orders = Order::whereDoesntHave('payment')->get();

        $paymentMethods = [
            'wallet' => 'محفظة جوالي',
            'kareemy' => 'محفظة جيب الكريمي',
            'bank_transfer' => 'تحويل بنكي',
            'cash' => 'نقداً'
        ];

        return view('payments.create', [
            'orders' => $orders,
            'paymentMethods' => $paymentMethods
        ]);
    }

    /**
     * حفظ الدفعة الجديدة
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'orderId' => 'required|exists:orders,orderId',
            'amount' => 'required|numeric',
            'paymentMethod' => 'required|in:wallet,kareemy,bank_transfer,cash',
            'paymentDate' => 'required|date',
            'status' => 'required|in:paid,pending,failed,refunded'
        ]);

        Payment::create($validated);

        return redirect()->route('payments.index')
               ->with('success', 'تمت إضافة الدفعة بنجاح');
    }

    /**
     * عرض تفاصيل دفعة معينة
     */
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    /**
     * عرض نموذج تعديل الدفعة
     */
    public function edit(Payment $payment)
    {
        $orders = Order::all();
        return view('payments.edit', compact('payment', 'orders'));
    }

    /**
     * تحديث بيانات الدفعة
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'orderId' => 'required|exists:orders,orderId',
            'amount' => 'required|numeric|min:0',
            'paymentMethod' => 'required|string|max:50',
            'paymentDate' => 'required|date',
            'status' => 'required|in:paid,pending,failed,refunded'
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')->with('success', 'تم تحديث الدفعة بنجاح');
    }

    /**
     * حذف الدفعة
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'تم حذف الدفعة بنجاح');
    }
}
