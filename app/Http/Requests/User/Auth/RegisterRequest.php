<?php

namespace App\Http\Requests\User\Auth;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends APIRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string' ,'max:50'] ,
            'email' => ['required','email','unique:users,email'],
            'password' => ['required' ,'string' ,'min:8','confirmed'] ,
//            'password_confirmation' => ['required' ,'same:password']
        ];
    }
}
