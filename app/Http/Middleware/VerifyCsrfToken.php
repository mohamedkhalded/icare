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
        //
       'http://localhost:8000/clinic/register',
       'http://localhost:8000/pharmcy/register',
       'http://localhost:8000/clinic/login',
       'http://localhost:8000/laporatory/register'
    ];
}
