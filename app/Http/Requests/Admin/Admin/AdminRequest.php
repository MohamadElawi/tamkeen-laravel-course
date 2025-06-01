<?php

namespace App\Http\Requests\Admin\Admin;

use App\Enums\StatusEnum;
use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminRequest extends APIRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','max:50'],
            'email' => ['required','unique:admins,email','email'],
            'phone' => ['required' ,'unique:admins,phone','string','digits:10'] ,
            'password' => ['required','string' ,'min:8' ,'confirmed'] ,
            'status' => ['required', Rule::enum(StatusEnum::class)]
        ];
    }
}
