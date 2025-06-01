<?php

namespace App\Http\Requests\AssignPermission;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\ValidationHandler;
use Illuminate\Validation\Rule;
class AssignRMPRequest extends FormRequest
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
            'role_id' => [
                'required',
                'integer',
                'exists:roles,id',
            ],
            'module_id' => [
                'required',
                'integer',
                'exists:modules,id',
            ],
            'permission_id' => [
                'required',
                'integer',
                'exists:permissions,id',
                Rule::unique('role_module_permissions')->where(function ($query) {
                    return $query->where('role_id', request('role_id'))
                        ->where('module_id', request('module_id'));
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'role_id.required' => 'The role ID is required.',
            'module_id.required' => 'The module ID is required.',
            'permission_id.required' => 'The permission ID is required.',
            'permission_id.exists' => 'The selected permission ID is invalid.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationHandler($validator);
    }

}

