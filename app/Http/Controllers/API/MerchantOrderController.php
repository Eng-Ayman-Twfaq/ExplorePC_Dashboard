<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class MerchantOrderController extends Controller
{
    /**
     * عرض الطلبات التي تحتوي على منتجات التاجر
     *
     * @param  int  $merchantId
     * @return \Illuminate\Http\Response
     */
    public function getMerchantOrders($merchantId)
    {
        try {
            // الحصول على جميع الطلبات التي تحتوي على منتجات التاجر
            $orders = Order::whereHas('items.product', function($query) use ($merchantId) {
                    $query->where('MerchantId', $merchantId);
                })
                ->with(['customer', 'items.product' => function($query) use ($merchantId) {
                    $query->where('MerchantId', $merchantId);
                }])
                ->orderBy('orderDate', 'desc')
                ->get()
                ->map(function ($order) use ($merchantId) {
                    // تصفية العناصر لتحتوي فقط على منتجات التاجر
                    $filteredItems = $order->items->filter(function ($item) use ($merchantId) {
                        return $item->product && $item->product->MerchantId == $merchantId;
                    });
                    
                    // حساب المجموع الجزئي لمنتجات التاجر فقط
                    $merchantTotal = $filteredItems->sum(function ($item) {
                        return $item->getTotalPrice();
                    });
                    
                    return [
                        'orderId' => $order->orderId,
                        'customerName' => $order->customer->UserName ?? 'غير معروف',
                        'orderDate' => $order->orderDate,
                        'totalAmount' => $order->totalAmount,
                        'merchantTotal' => $merchantTotal,
                        'shippingAddress' => $order->shippingAddress,
                        'status' => $order->status,
                        'items' => $filteredItems->map(function ($item) {
                            return [
                                'productName' => $item->product->name ?? 'منتج محذوف',
                                'quantity' => $item->quantity,
                                'price' => $item->price,
                                'total' => $item->getTotalPrice(),
                            ];
                        }),
                    ];
                });

            return response()->json([
                'status' => 'success',
                'orders' => $orders
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء جلب الطلبات'
            ], 500);
        }
    }
}