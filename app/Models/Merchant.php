<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $primaryKey = 'MerchantId';
    protected $fillable = [
        'name',
        'email',
        'phoneNumber',
        'Address',
        'storename',
        'rating',
        'password', // إضافة الحقل
    ];

    protected $hidden = [
        'password', // إخفاء كلمة السر عند التحويل لـ JSON
        'remember_token',
    ];

    // العلاقات
    public function documents()
    {
        return $this->hasMany(MerchantDocument::class, 'MerchantId');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'MerchantId');
    }
    public function orders()
{
    return $this->hasMany(Order::class);
}
}
