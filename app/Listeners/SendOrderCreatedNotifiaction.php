<?php

namespace App\Listeners;

use App\Events\CartCreated;
use App\Models\User;
use App\Notifications\OrderCreatNotifiaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotifiaction
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(CartCreated $event): void
    {
       $order =$event->order;
       $user=User::where('store_id',$order->store_id)->first();
    //    dd($user);
       $user->notify(new OrderCreatNotifiaction($order));
       //بلكي عتدي الستور اكتر من يوزر 
    //    $users=User::where('store_id',$order->store_id)->get();
    //    Notification::send($users ,new OrderCreatNotifiaction($order));
    //    foreach($users as $user)
    //    {
    //     $user->notify(new OrderCreatNotifiaction($order));
    //    }


    }
}
