<?php

namespace App\Http\Requests\Permissions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Exceptions\ValidationHandler;
class StoreRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:permissions,name',
            'guard_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'guard_name.required' => 'The guard name field is required.',
            'description.max' => 'The description may not be greater than 1000 characters.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'guard_name' => $this->input('guard_name') ?? 'api', // Default to 'api' if not provided
        ]);
    }


    protected function failedValidation(Validator $validator)
    {
        throw new ValidationHandler($validator);
    }
}
