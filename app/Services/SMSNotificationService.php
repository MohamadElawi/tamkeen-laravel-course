<?php

namespace App\Services;

use App\Interfaces\NotificationInterface;

class SMSNotificationService implements NotificationInterface
{
    public function send($message)
    {
        return "Notification send : {$message}  via SMS" ;
    }
}
