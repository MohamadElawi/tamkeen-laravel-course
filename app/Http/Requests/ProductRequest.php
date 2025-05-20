<?php

namespace App\Http\Requests;
use App\Enums\StatusEnum;
use App\Http\Requests\APIRequest;
use Illuminate\Validation\Rule;


class ProductRequest extends APIRequest
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
            'name_ar' => 'required|string|max:255|',
            'name_en' => 'required|string|max:255|',
            'price' => 'numeric|between:10,10000000',
            'description' => 'lowercase',
            'status' => ['required' ,Rule::enum(StatusEnum::class)] ,
            'image' => ['required' ,'image' ,'max:4096'] ,
            'gallery' => ['array','sometimes'] ,
            'gallery.*' => ['required','image' ,'max:4096'] ,
            'color_ids' => 'required|array|min:1',
            'color_ids.*' => ['required','exists:colors,id']
        ];
    }

    public function messages()
    {
        return [
            'name_ar.required' => 'you must enter the name of product',
            'name_en' => 'you must enter the name of produc',
            'price.*' => 'the price should be number betwwen 10->1000',
            'description.lowercase' => 'please enter the description with lowercase letters',
        ];
    }

    public function attributes()
    {
        return [
          'color_ids.*'  => 'Color id'
        ];
    }
}
