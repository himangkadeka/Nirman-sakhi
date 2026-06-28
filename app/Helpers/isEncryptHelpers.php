<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

if (!function_exists('isEncrypted')) {
    function isEncrypted($string)
    {
        try {
            Crypt::decryptString($string);
            return true;
        } catch (DecryptException $e) {
            return false;
        }
    }
}
