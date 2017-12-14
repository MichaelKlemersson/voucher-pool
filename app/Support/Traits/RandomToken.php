<?php

namespace App\Support\Traits;

trait RandomToken
{
    public function generateToken($length = 8)
    {
        $wordBytes = 16;
        $token = '';

        if(!isset($length) || intval($length) < 8 ) {
          $length = 8;
        }
        if (function_exists('random_bytes')) {
            $token = bin2hex(random_bytes($wordBytes));
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            $token = bin2hex(openssl_random_pseudo_bytes($wordBytes));
        }

        return substr($token, 0, $length);
    }
}
