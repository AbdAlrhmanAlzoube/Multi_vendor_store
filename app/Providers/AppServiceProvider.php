<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Cart\CartModelRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(CartRepository::class, CartModelRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('filter', function ($attribute, $value, $parameters) {
            return !in_array(strtolower($value), $parameters);
        }, 'The value is prohibited.');

        Paginator::useBootstrapFour();
        // Paginator::defaultView('vendor.pagination.tailwind');
        Blade::component('form.select', 'form.select');

    }
}
