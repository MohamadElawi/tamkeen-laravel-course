<?php

namespace App\Listeners;

use App\Events\OrderCompleted;
use App\Mail\SendInvoiceMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInvoice
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
    public function handle(OrderCompleted $event): void
    {
        $userEmail = $event->order->user->email;
        Mail::to($userEmail)->send(new SendInvoiceMail($event->order));
    }
}
