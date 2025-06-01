<?php

namespace App\Http\Requests\Admin\Auth;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends APIRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required','email','exists:admins,email'],
            'password' => ['required','string' ,'min:8']
        ];
    }
}
