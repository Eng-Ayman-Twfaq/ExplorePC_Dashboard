<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $primaryKey = 'productId';
    protected $fillable = [
    'MerchantId',
    'name',
    'description',
    'price',
    'category',
    'stockQuantity',
    'image',
    'ratings'
    ];

    // العلاقات
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'MerchantId');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'productId');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'productId');
    }

    // Methods
    public function calculateAverageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function getRemainingStock()
    {
        return $this->stockQuantity;
    }
}
