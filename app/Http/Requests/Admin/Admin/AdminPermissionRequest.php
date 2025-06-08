<?php

namespace App\Http\Requests\Admin\Admin;

use App\Enums\PermissionEnum;
use App\Enums\RoleEnum;
use App\Http\Requests\APIRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminPermissionRequest extends APIRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'permission_names' => ['required','array','min:1'],
            'permission_names.*' => ['required',Rule::enum(PermissionEnum::class)]
        ];
    }
}
