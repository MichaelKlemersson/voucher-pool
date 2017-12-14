<?php

namespace App\Domains\Vouchers\Exceptions;

class InvalidVoucherEndDateException extends \Exception
{
    protected $code = 1001;

    protected $message = 'Invalid end date for voucher';
}
