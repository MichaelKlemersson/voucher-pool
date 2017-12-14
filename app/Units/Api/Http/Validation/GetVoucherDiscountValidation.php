<?php

namespace App\Units\Api\Http\Validation;

use Illuminate\Validation\Rule;

class GetVoucherDiscountValidation
{
    public function authorize()
    {
        return true;
    }

    public function rules(array $requestParams = [])
    {
        return [
            'code' => [
                'required',
                'min:8',
                Rule::exists('vouchers')->where(function ($query) use ($requestParams) {
                    $query->where([
                        ['code', '=', $requestParams['code']],
                        ['used_date', '=', null],
                    ]);
                })
            ],
        ];
    }
}
