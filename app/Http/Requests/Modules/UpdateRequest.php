<?php

namespace App\Http\Requests\Modules;
use App\Exceptions\ValidationHandler;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class UpdateRequest extends FormRequest
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
        $id = $this->route("id");
        return [
            'name' => 'required|string|max:255',
            'slug' => "required|string|max:255|unique:modules,slug,$id",
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
