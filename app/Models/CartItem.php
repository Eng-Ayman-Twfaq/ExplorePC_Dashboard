<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $primaryKey = 'cart_item_id';
    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    // العلاقات
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Methods
    public function getTotalPrice()
    {
        return $this->quantity * $this->product->price;
    }
}
