<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function processPayment(Request $request, $orderId)
    {
        // التحقق من وجود الطلب
        $order = Order::with('payment')->find($orderId);
        
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود'
            ], 404);
        }

        // التحقق إذا كان الطلب مدفوعاً مسبقاً
        if ($order->payment && $order->payment->status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'هذا الطلب مدفوع مسبقاً، لا يمكن الدفع أكثر من مرة'
            ], 400);
        }

        // التحقق من الصحة
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:الدفع عند الاستلام,محفظة جوالي,كريمي,محفظة جيب'
        ], [
            'payment_method.in' => 'طريقة الدفع المختارة غير مدعومة'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {
            // إذا كان هناك دفع مسبق (قيد الانتظار) نحدثه، وإلا ننشئ جديد
            if ($order->payment) {
                $payment = $order->payment;
                $payment->update([
                    'paymentMethod' => $request->payment_method,
                    'paymentDate' => now()
                ]);
            } else {
                $payment = Payment::create([
                    'orderId' => $order->orderId,
                    'amount' => $order->totalAmount,
                    'paymentMethod' => $request->payment_method,
                    'paymentDate' => now(),
                    'status' => 'قيد الانتظار'
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل طريقة الدفع بنجاح',
                'payment' => $payment
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'فشل في معالجة الدفع',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}