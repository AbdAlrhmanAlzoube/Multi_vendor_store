<?php

namespace App\Providers;

use App\Events\CartCreated;
use App\Listeners\DeductProductQuantity;
use App\Listeners\EmptyCart;
use App\Listeners\SendOrderCreatedNotifiaction;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

     protected $listen = [

        CartCreated::class => [
            DeductProductQuantity::class,
            SendOrderCreatedNotifiaction::class,
            // EmptyCart::class,
        ]


    ];

    
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
