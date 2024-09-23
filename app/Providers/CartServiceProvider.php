<?php

namespace App\Providers;

use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use phpDocumentor\Reflection\Types\Parent_;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {


        
        $this->app->singleton(CartRepository::class, CartModelRepository::class);

        $this->app->bind('abilities', function() {
            return include base_path('app/Data/ability.php');
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();
      
    }
}
