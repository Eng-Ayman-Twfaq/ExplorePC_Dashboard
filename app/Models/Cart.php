<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $primaryKey = 'cartId';
    protected $fillable = ['UserId'];

    // العلاقات
    public function customer()
    {
        return $this->belongsTo(Custom::class, 'UserId');
    }

    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    // Methods
    public function calculateTotal()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }
}
