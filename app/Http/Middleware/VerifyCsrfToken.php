<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/user/save-workshop-note',
        '/auth/signup',
        '/auth/verify-otp',
        '/auth/authentication',
        '/auth/resend-otp',
        '/save-workshop-batch-details',
        '/bounces-production-notification',
        '/complaints-production-notification',
        '/deliveries-production-notification'
    ];
}
