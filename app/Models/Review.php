<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $primaryKey = 'reviewId';
    public $incrementing = true;

    protected $fillable = [
        'productId',
        'UserId',
        'rating',
        'comment',
        'date'
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(Custom::class, 'UserId', 'UserId');
    }

    // العلاقة مع المنتج
    public function product()
    {
        return $this->belongsTo(Product::class, 'productId', 'productId');
    }
}
