<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    protected $table = 'customs';
    protected $primaryKey = 'UserId';
    public $incrementing = true;
    protected $fillable = [
        'UserName',
        'email',
        'UserPassword',
        'Phone',
        'Address',
        'Image'
    ];

    protected $hidden = [
        'UserPassword',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->UserPassword;
    }

    // العلاقات
    public function carts()
    {
        return $this->hasMany(Cart::class, 'UserId');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'UserId');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'UserId');
    }

    // public function getAuthPassword()
    // {
    //     return $this->UserPassword;
    // }
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
}
