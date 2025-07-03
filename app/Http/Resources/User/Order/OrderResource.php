<?php

namespace App\Http\Resources\User\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'user' => $this->user ,
            'total' => formatPrice($this->total ) ,
            'sub_total' => formatPrice($this->sub_total) ,
            'tax' => formatPrice($this->tax) ,
            'order_products' => $this->orderProducts
        ];
    }
}
