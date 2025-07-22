<?php

namespace App\Classes;

use App\Interfaces\NotificationInterface;
use App\Services\MailNotificationService;
use App\Services\SMSNotificationService;
use Illuminate\Support\Facades\Facade;

class Notification extends Facade
{
//    public function send($message){
//        return $message;
//    }


    protected static function getFacadeAccessor()
    {
//        return MailNotificationService::class;
        return 'notification';
    }

//    public static function __callStatic(string $name, array $arguments)
//    {
//        return (new SMSNotificationService())->send($arguments[0]);
//    }

//    public function __call(string $name, array $arguments)
//    {
//        // TODO: Implement __call() method.
//    }


}
