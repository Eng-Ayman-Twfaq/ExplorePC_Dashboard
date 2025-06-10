<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'orderId';
    protected $fillable = [
        'UserId',
        'orderDate',
        'totalAmount',
        'shippingAddress',
        'status'
    ];

    // العلاقات
    public function customer()
    {
        return $this->belongsTo(Custom::class, 'UserId');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'orderId');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'orderId');
    }
     // دالة لحساب المجموع التلقائي
     public function calculateTotal()
     {
         $this->totalAmount = $this->items->sum(function($item) {
             return $item->quantity * $item->price;
         });
         $this->save();
     }
      public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'MerchantId'); // تأكد من أن اسم العمود هو merchant_id
    }
    public function products()
{
    return $this->belongsToMany(Product::class)
        ->withPivot('quantity', 'price');
}
}
