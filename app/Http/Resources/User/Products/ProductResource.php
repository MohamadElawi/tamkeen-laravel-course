<?php

namespace App\Http\Resources\User\Products;

use App\Enums\Media\ProductMediaEnum;
use App\Http\Resources\CategoryResource;
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
            'id' => $this->id ,
            'name' => $this->name ,
            'price' => $this->price ,
            'quantity' => $this->quantity ,
            'status_value' => $this->status->value ,
            'status' => $this->status->translate() ,
            'categories' => $this->whenLoaded('categories',CategoryResource::collection($this->categories)) ,
            'colors' => $this->colors ,
            'image' => $this->getFirstMediaUrl(ProductMediaEnum::MAIN_IMAGE->value)
        ];
    }
}
