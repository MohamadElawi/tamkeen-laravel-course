<?php

namespace App\Http\Requests\User\Auth;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class VerifyAccountRequest extends APIRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required' ,'email', 'exists:users,email'] ,
            'verification_code' => ['required' ,'string','digits:6']
        ];
    }
}
