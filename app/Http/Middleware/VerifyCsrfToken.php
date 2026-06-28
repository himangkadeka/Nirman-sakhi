<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/sewasetu/registration',
        'api/sewasetu/track-application-status',
        'e-grass/sub-system/response',
        'e-grass/get-cin',
        'api/csc/payment/success',
        'api/csc/payment/response',
        'api/csc/subscription-payment/response'
    ];
}
