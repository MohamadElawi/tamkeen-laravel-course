<?php

namespace App\Http\Resources;

use App\Enums\Media\ColorMediaEnum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
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
            'title' => $this->title ,
            'status' => $this->status->value ,
            'image' => $this->getFirstMediaUrl(ColorMediaEnum::MAIN_IMAGE->value),
            'created_at' => $this->created_at
        ];
    }
}
