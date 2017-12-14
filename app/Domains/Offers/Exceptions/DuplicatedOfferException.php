<?php

namespace App\Domains\Offers\Exceptions;

class DuplicatedOfferException extends \Exception
{
    protected $code = 1000;

    protected $message = 'An offer already exists with this name';
}