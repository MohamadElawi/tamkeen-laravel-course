<?php

namespace App\Observers;

use App\Enums\OrderStatusEnum;
use App\Mail\SendInvoiceMail;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    public function updating(Order $order){
        if($order->getOriginal('status') == OrderStatusEnum::PENDING &&
            $order->status == OrderStatusEnum::ACCEPTED){
            $userEmail = $order->user->email;
            Mail::to($userEmail)->send(new SendInvoiceMail($order));
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {

    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
