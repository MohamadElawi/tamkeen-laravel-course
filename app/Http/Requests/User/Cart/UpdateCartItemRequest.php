<?php

namespace App\Http\Requests\User\Cart;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemRequest extends APIRequest
{

//    public function authorize(): bool
//    {
////        return auth('user_id') ==
//    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'quantity' => ['required','min:1','numeric']
        ];
    }
}
