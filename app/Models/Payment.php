<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $primaryKey = 'paymentId';
    protected $fillable = [
        'orderId',
        'amount',
        'paymentMethod',
        'paymentDate',
        'status'
    ];

    // العلاقات
    public function order()
    {
        return $this->belongsTo(Order::class, 'orderId');
    }
}
