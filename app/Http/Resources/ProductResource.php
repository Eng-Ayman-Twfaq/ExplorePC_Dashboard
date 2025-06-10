<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'productId'=>$this->productId,
            'MerchantId'=>$this->MerchantId,
            'name'=>$this->name,
            'description'=>$this->description,
            'price'=>$this->price,
            'category'=>$this->category,
            'stockQuantity'=>$this->stockQuantity,
            'image'=>$this->image,
            'ratings'=>$this->ratings,
            ];

    }
}
