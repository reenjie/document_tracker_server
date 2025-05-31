<?php

namespace App\Exceptions;
use Illuminate\Validation\ValidationException;
use Exception;

class ValidationHandler extends Exception
{
    protected $validator;
    public function __construct($validator)
    {
        $this->validator = $validator;
    }
    public function render()
    {
        throw new ValidationException($this->validator, response()->json([
            'message' => 'Validation failed',
            'errors' => $this->validator->errors(),
        ], 422));
    }
}
