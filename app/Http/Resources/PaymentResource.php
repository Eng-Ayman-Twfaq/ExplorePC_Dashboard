<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'paymentId' => $this->paymentId,
            'orderId' => $this->orderId,
            'amount' => $this->amount,
            'paymentMethod' => $this->paymentMethod,
            'paymentDate' => $this->paymentDate->format('Y-m-d H:i:s'),
            'status' => $this->status,
            'createdAt' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}