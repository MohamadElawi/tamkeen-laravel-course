<?php

namespace App\Http\Requests\User\Order;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends APIRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
