<?php

namespace App\Http\Requests\AssignPermission;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\ValidationHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssignUserRole extends FormRequest
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
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],
            'user_role_permission_id' => [
                'required',
                'integer',
                'exists:role_module_permissions,id',
                Rule::unique('user_role_permissions') // <- your pivot or mapping table
                    ->where(function ($query) {
                        return $query->where('user_id', request('user_id'));
                    }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'RMP.required' => 'The Role Module Permission ID is required.',
            'RMP.exists' => 'The selected Role Module Permission ID is invalid.',
        ];
    }

    protected function prepareForValidation()
    {
        // You can manipulate the data before validation if needed
        $this->merge([
            'user_id' => (int) $this->route('user_id'),
            'user_role_permission_id' => (int) $this->route('RMP'),
        ]);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationHandler($validator);
    }
}
