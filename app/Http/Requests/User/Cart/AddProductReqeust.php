<?php

namespace App\Http\Requests\User\Cart;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class AddProductReqeust extends APIRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required','numeric'] ,
            'quantity' => ['required','numeric' ,'min:1'],
            'color_id' => ['required','exists:colors,id']
        ];
    }
}
