<?php

namespace App\Http;

use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Symfony\Component\HttpKernel\HttpKernel;

class Kernel extends HttpKernel
{
    protected $middleware = [
        ConvertEmptyStringsToNull::class,
    ];

    protected $middlewareGroups = [
        'web' => [

        ],
        'api' => [
            SubstituteBindings::class,
        ],
    ];
}
