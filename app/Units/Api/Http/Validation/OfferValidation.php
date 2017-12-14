<?php

namespace App\Units\Api\Http\Validation;

class OfferValidation
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'discount' => 'required|numeric|min:0|max:100.00'
        ];
    }
}
