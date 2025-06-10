<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'orderItemId' => $this->orderItemId,
            'productId' => $this->productId,
            'productName' => $this->product->name, // افترض أن لديك علاقة مع نموذج Product
            'quantity' => $this->quantity,
            'price' => $this->price,
            'total' => $this->quantity * $this->price,
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}