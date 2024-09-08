<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'store_id',
        'payment_method',
        'status',
        'payment_status',
    ];
    
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault(['name'=>'Guset Customer']);//BECOSE nullable
    }

    public function products() // بالعلاقات مني تو مني لازم اراعي اسناء الجداول 
    {                                                                            //بعلاثقات المني بس بشوف الفورن كي كيف بدي خليه يشوف باقي الحقول
        return $this->belongsToMany(Product::class,'order_items','order_id','product_id','id','id')
        ->using(OrderItem::class)
         //لامو لارفيل عالبا الجدول الكسر ما الو موديل لهيك بقلو هالشي 
        ->withPivot(['product_name','price','quantity','options']); //use withPivot chenge extends model pivot //OrderItem
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddresses::class);
    }
    public function billingaddress()
    {
        return $this->hasOne(OrderAddresses::class,'order_id','id')->where('type','=','billing');
    }
    public function shoppingaddress()
    {
        return $this->hasOne(OrderAddresses::class,'order_id','id')->where('type','=','shopping');
    }


    public static function booted()
    {
        static::creating(function(Order $order)
        {
            $order->number=Order::getNextOrderNumber();
        });
    }

    public static function getNextOrderNumber()
    {
        $year=Carbon::now()->year;
        $number=Order::whereYear('created_at',$year)->max('number');

        if($number)
        {
            return $number + 1;
        }
        return $year + 0001;
    }
}
