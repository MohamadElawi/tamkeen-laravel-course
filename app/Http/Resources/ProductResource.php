<?php

namespace App\Http\Resources;

use App\Enums\Enums\Media\ProductMediaEnum;
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
        $data =  parent::toArray($request);

        return array_merge($data ,[
            'colors' => ColorResource::collection($this->colors),
            'image' => $this->getFirstMediaUrl(ProductMediaEnum::MAIN_IMAGE->value) ,
            'gallery' => $this->getMedia(ProductMediaEnum::GALLERY->value)
                ->map(function($image){
                return $image->original_url ;
            }) ,
        ]);
    }
}
