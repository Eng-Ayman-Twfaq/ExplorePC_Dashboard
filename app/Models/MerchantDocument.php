<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantDocument extends Model
{
    protected $primaryKey = 'documentId';
    protected $fillable = [
        'MerchantId',
        'documentType',
        'documentImage',
        'uploadDate',
        'status'
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'MerchantId');
    }
}
