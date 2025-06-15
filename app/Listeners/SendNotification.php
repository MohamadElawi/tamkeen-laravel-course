<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Mail\SendMailTOAdmin;
use App\Models\Admin;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendNotification
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
    public function handle(UserRegistered $event): void
    {
        $admin = Admin::where('email','super@gmail.com')->first();

        try{
            Mail::to($admin->email)->send(new SendMailTOAdmin($admin ,$event->user));
        }catch (\Exception $e){
            // handle for exception
        }
    }
}
