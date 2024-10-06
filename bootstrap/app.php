<?php

use App\Exceptions\order;
use App\Http\Middleware\CheckApiToken;
use App\Http\Middleware\CheckUserType;
use App\Http\Middleware\MarkNotificationAsRead;
use App\Http\Middleware\SetAppLocale;
use Illuminate\Foundation\Application;
use App\Http\Middleware\UpdateUserLastActiveAt;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            'auth:sanctum' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'auth_type' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'auth_type' => CheckUserType::class,
            // 'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
            // 'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
            // 'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
            // 'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
            // 'localeViewPath'          => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
            // 'setlocale'=> SetAppLocale::class,
            
            
        ]);
        $middleware->appendToGroup('web',[
            UpdateUserLastActiveAt::class, 
            MarkNotificationAsRead::class,
            // SetAppLocale::class,
        ],);
        $middleware->validateCsrfTokens(['stripe/webhook'],);
        
        $middleware->appendToGroup('api', [
            CheckApiToken::class,
        ]);

        $middleware->validateCsrfTokens([
            'paypal/webhook',
        ]);
       
        
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->report(function (QueryException $e,Request $request) {
        //     if ($e->getCode() == 23000) {
        //     Log::channel('sql')->warning('');
        //         $message = 'Foreign key constraint failed';
        //     } else {
        //         $message = $e->getMessage();
        //     }

        //     if ($request->expectsJson()) {
        //         return response()->json([
        //             'message' => $message,
        //         ], 400);
        //     }

        //     return redirect()
        //         ->back()
        //         ->withInput()->withErrors([
        //             'message' => $e->getMessage(),
        //         ])
        //         ->with('info', $message);
        //         });
        
        
    })->create();
