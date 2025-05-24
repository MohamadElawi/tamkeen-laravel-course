<?php

namespace App\Http\Requests;

use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;

class UpdateColorsRequest extends APIRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'color_ids' => ['required' ,'array','min:1'] ,
            'color_ids.*' => ['required' ,'exists:colors,id']
        ];
    }
}
