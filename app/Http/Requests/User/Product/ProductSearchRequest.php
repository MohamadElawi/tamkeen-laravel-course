<?php

namespace App\Http\Requests\User\Product;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProductSearchRequest extends APIRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'count' => ['sometimes','numeric'] ,
            'search' => ['sometimes','string'] ,
            'color_id' => ['sometimes','exists:colors,id'] ,
            'price_from' => ['sometimes','numeric' ] ,
            'price_to' => ['sometimes','numeric']
        ];
    }
}
