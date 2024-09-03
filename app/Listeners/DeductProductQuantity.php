<?php

namespace App\Listeners;

use App\Events\CartCreated;
use App\Facdes\Cart;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event)
    {
        // dd($order->products);
        $order=$event->order;
        foreach($order->products as $product)
        {
            $product->decrement('quantity',$product->pivot->quantity);
        }
        // foreach(Cart::get() as $item)
        // {
        //     Product::where('id','=',$item->product_id)
        //     ->update([
        //         'quantity' => DB::raw("quantity - . {$item->quantity}"), //DB::raw لختئ اقدر اكتب استعلان مو سترينغ
        //     ]);
        // }
    }
}
