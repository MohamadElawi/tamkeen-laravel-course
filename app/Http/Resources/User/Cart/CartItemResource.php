<?php

namespace App\Http\Resources\User\Cart;

use App\Http\Resources\User\Products\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'quantity' => $this->quantity ,
            'product' => $this->product ,
            'color' => $this->color ,
        ];
    }
}
