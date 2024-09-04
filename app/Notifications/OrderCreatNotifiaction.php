<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatNotifiaction extends Notification
{
    use Queueable; //طابور 


    protected $order;
    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order) 
    {
        $this->order=$order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array //objact user authintacit //بترجع طرق استلام الاشعارات 
    {   
        return ['mail','database'];
        $channels=['database'];

        if($notifiable->notifiaction_preferences['order_created']['sms'] ?? false)
        {
            return $channels[]='vonage';
        }
        if($notifiable->notifiaction_preferences['order_created']['mail'] ?? false)
        {
            return $channels[]='mail';
        }
        if($notifiable->notifiaction_preferences['order_created']['broadcast'] ?? false)
        {
            return $channels[]='broadcast';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $addr=$this->order->billingaddress;
        return (new MailMessage)
                    ->subject("New Order #{$this->order->number}")
                    // ->from('abd@abd.abd','abode')
                    ->greeting("Hi.{$notifiable->name},")
                    ->line("A New Order ({$this->order->number}) Created by {$addr->name} from {$addr->country_name}.")
                    ->action('View Order', url('/dashboard'))
                    ->line('Thank you for using our application!');
                    //view(''); 
    }

    public function toDatabase($notifiable)
    {
        $addr=$this->order->billingaddress;
        return[
            'body'=>"A New Order ({$this->order->number}) Created by {$addr->name} from {$addr->country_name}.",
            'icon' => 'fas fa-file',
            'url'=>'/dashboard',
            'order_id'=>$this->order->id,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
