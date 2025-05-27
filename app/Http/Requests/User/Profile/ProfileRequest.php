<?php

namespace App\Http\Requests\User\Profile;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends APIRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = auth('user')->id();
        return [
            'name' => ['required','string' ,'max:50'] ,
            'email' => ['required','email',"unique:users,email,$userId"] ,
            'image' => ['sometimes','image','mimes:jpg,png','max:4096']
        ];
    }
}
