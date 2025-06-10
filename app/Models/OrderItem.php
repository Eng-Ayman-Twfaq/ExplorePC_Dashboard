<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'orderItemId';
    protected $fillable = [
        'orderId',
        'productId',
        'quantity',
        'price'
    ];

    // العلاقات
    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }

    // Methods
    public function getTotalPrice()
    {
        return $this->quantity * $this->price;
    }
}
