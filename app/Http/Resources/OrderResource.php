<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'orderId' => $this->orderId,
            'userId' => $this->UserId,
            'orderDate' => $this->orderDate instanceof \DateTime 
            ? $this->orderDate->format('Y-m-d H:i:s')
            : \Carbon\Carbon::parse($this->orderDate)->format('Y-m-d H:i:s'),
            'totalAmount' => $this->totalAmount,
            'shippingAddress' => $this->shippingAddress,
            'status' => $this->status,
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
            'createdAt' => $this->created_at->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}