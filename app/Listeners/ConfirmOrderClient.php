<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ConfirmOrder;
use App\Mail\OrderConfirmationMail;
use App\Notifications\ConfirmOrderClientNotification;
use Illuminate\Support\Facades\Mail;

class ConfirmOrderClient implements ShouldQueue
{
    use InteractsWithQueue;
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
    public function handle(ConfirmOrder $event)
    {

        $order = $event->order;
        $email = $order->email;
        // dd($email = $order->email);


        $order->notify(new ConfirmOrderClientNotification($order));
        Mail::to($email)->send(new OrderConfirmationMail($order));
    }
}
