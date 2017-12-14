<?php

namespace App\Units\Api\Http\Validation;

class VoucherValidation
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'offer' => 'required|exists:offers,id',
            'end_date' => 'required|date|date_format:"Y-m-d H:i:s"'
        ];
    }
}