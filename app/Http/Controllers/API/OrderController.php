<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'UserId' => 'required|exists:customs,UserId',
        'orderDate' => 'required|date',
        'shippingAddress' => 'required|string|max:255',
        'status' => 'required|in:قيد الانتظار,قيد المعالجة,مكتمل,ملغى',
        'products' => 'required|array|min:1',
        'products.*.productId' => 'required|exists:products,productId',
        'products.*.quantity' => 'required|integer|min:1',
        'products.*.price' => 'required|numeric|min:0'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors' => $validator->errors()
        ], 422);
    }

    DB::beginTransaction();

    try {
        $order = Order::create([
            'UserId' => $request->UserId,
            'orderDate' => Carbon::parse($request->orderDate),
            'shippingAddress' => $request->shippingAddress,
            'status' => $request->status,
            'totalAmount' => 0
        ]);

        $totalAmount = 0;
        foreach ($request->products as $product) {
            OrderItem::create([
                'orderId' => $order->orderId,
                'productId' => $product['productId'],
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]);
            $totalAmount += $product['quantity'] * $product['price'];
        }

        $order->update(['totalAmount' => $totalAmount]);
        DB::commit();

        return response()->json([
            'success' => true,
            'order' => $order->load('items')
        ], 201);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Order creation error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'فشل في إنشاء الطلب',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function getUserOrders($userId)
{
    $orders = Order::with(['items.product'])
        ->where('UserId', $userId)
        ->orderBy('orderDate', 'desc')
        ->get();

    return response()->json($orders);
}
}