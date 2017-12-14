<?php

namespace App\Units\Api\Http\Validation;

class ListRecipientVoucherValidation
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => 'required|exists:recipients'
        ];
    }
}