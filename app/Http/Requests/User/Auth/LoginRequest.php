<?php

namespace App\Http\Requests\User\Auth;

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
            'email' => ['required','email','string','exists:users,email'],
            'password' => ['required','string','min:8']
        ];
    }
}
