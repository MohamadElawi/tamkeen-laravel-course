<?php

namespace App\Http\Requests;
use App\Http\Requests\APIRequest;

class CategoryRequest extends APIRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
//            'name' => 'required|array' ,
//            'name.en' => 'required|string|max:255' ,
//            'name.ar' => 'required|string|max:255'
            'name_ar' => 'required|string|max:255|',
            'name_en' => 'required|string|max:255|'
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => __('you_must_enter_the_name_of_category'),
            'name_en.required' => __('you_must_enter_the_name_of_category'),
        ];
    }
}
