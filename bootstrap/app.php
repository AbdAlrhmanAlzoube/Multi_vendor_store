<?php

use App\Http\Middleware\CheckUserType;
use Illuminate\Foundation\Application;
use App\Http\Middleware\UpdateUserLastActiveAt;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth_type' => CheckUserType::class,
            'update_last_active' => UpdateUserLastActiveAt::class,

        ]);
        $middleware->validateCsrfTokens([
            'paypal/webhook',
        ]);
        
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
