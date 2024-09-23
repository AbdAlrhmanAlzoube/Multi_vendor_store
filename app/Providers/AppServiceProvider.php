<?php

namespace App\Providers;

use App\Models\Cart;
use App\Events\CartCreated;
use App\Models\Role;
use App\Observers\CartObserver;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use App\Observers\NotificationObserver;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{

    public const HOME='/';
    /**
     * 
     * Register any application services.
     */
    public function register(): void
    {
        // $this->app->bind(CartRepository::class, CartModelRepository::class);
        $this->app->bind('update.role', function () {
            return new Role();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // URL::defaults(Config('app,locale'));
            
      
        JsonResource::withoutWrapping();

        Validator::extend('filter', function ($attribute, $value, $parameters) {
            return !in_array(strtolower($value), $parameters);
        }, 'The value is prohibited.');


        Paginator::useBootstrapFour();

        Gate::before(function ($user, $ability) {
            if ($user->super_admin) {
                return true;
            }
        });

        foreach($this->app->make('abilities') as $code =>$lable){
            Gate::define($code,function($user) use ($code){
                return $user->hasAbility($code);
            });
        }
        // DatabaseNotification::observe(NotificationObserver::class);
        // Paginator::defaultView('vendor.pagination.tailwind');
        // Blade::component('form.select', 'form.select');


        // Event::listen(
        //     CartCreated::class =>[ listenerName::class,]
           
        //);

        

        // Gate::allows('categories.view',function()
        // {
        //     return true;
        // });
        
        // Gate::define('categories.create',function()
        // {
        //     return true;
        // });
        
        // Gate::define('categories.update',function()
        // {
        //     return false;
        // });
        
        // Gate::define('categories.store',function()
        // {
        //     return true;
        // });
        
        // Gate::define('categories.delete',function()
        // {
        //     return false;
        // });
        

    }
}
