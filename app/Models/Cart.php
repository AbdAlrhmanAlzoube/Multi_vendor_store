<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Observers\CartObserver;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $fillable = [
        'cookie_id',
        'user_id',
        'product_id',
        'quantity',
        'options',
    ];

    protected static function boot()
    {
            parent::boot(); //=>BECOSE ERROR UNDIFINED ARRAY KEY
          static::observe(CartObserver::class);
          static::addGlobalScope('cookie_id',function(Builder $builder)
          {
            $builder->where('cookie_id', '=', Cart::getCookieId());
          });
        // parent::boot();
        // // Automatically generate UUIDs when creating new Cart entries
        // static::creating(function ($model) {
        //     if (empty($model->id)) {
        //         $model->id = Str::uuid();
        //     }
        // });
    }
    protected static function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = Str::uuid();
            // $cookieLifetime = config('session.cart_cookie_lifetime', 30); //;linkedin
            Cookie::queue('cart_id', $cookie_id, 30 * 24 *60);
        }
        return $cookie_id;
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(
            [
                'name'=>'Anonymous', //بسبب انو يمكن ما يكون عامل تسجيل دخول
            ]
            );
    }

   
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
