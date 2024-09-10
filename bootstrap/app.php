<?php

use App\Http\Middleware\CheckUserType;
use App\Http\Middleware\MarkNotificationAsRead;
use Illuminate\Foundation\Application;
use App\Http\Middleware\UpdateUserLastActiveAt;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
        apiPrefix:'api/v1',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth_type' => CheckUserType::class,
        ]);
        $middleware->appendToGroup('web',[
            UpdateUserLastActiveAt::class, 
            MarkNotificationAsRead::class,
        ]);
        $middleware->validateCsrfTokens([
            'paypal/webhook',
        ]);
        
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
