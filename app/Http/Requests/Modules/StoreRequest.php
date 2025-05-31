<?php

namespace App\Http\Requests\Modules;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
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
            'name' => 'required|string|max:255',
            'slug' => "required|string|max:255|unique:modules,slug",
            'description' => 'nullable|string|max:1000',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'The name field is required.',
            'slug.required' => 'The slug field is required.',
            'slug.unique' => 'The slug must be unique.',
            'description.max' => 'The description may not be greater than 1000 characters.',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationHandler($validator);
    }

}
