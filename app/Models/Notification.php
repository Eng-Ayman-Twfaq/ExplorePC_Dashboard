<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'is_read',
        'data'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array'
    ];

    // إضافة حقل is_general للتمييز بين الإشعارات العامة والخاصة
    protected $appends = ['is_general'];

    public function getIsGeneralAttribute()
    {
        return is_null($this->user_id);
    }

    public function user()
    {
        return $this->belongsTo(Custom::class, 'user_id', 'UserId');
    }
}