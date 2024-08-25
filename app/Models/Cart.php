<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
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
        static::observe(CartObserver::class);
          
        // parent::boot();
        // Automatically generate UUIDs when creating new Cart entries
        // static::creating(function ($model) {
        //     if (empty($model->id)) {
        //         $model->id = Str::uuid();
        //     }
        // });
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(
            [
                'name'=>'Anonymous',
            ]
            );
    }

   
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
