<?php

namespace App\Units\Api\Http\Validation;

class GetVoucherDiscountValidation
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|min:8|exists:vouchers,code'
        ];
    }
}