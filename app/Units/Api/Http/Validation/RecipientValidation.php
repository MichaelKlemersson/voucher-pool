<?php

namespace App\Units\Api\Http\Validation;

class RecipientValidation
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:recipients,email'
        ];
    }
}