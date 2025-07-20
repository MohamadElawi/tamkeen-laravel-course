<?php

namespace App\Services;

use App\Interfaces\NotificationInterface;

class MailNotificationService implements NotificationInterface
{
    protected $senderName ;
    protected $password ;

//    public function __construct( $senderName , $password)
//    {
//        $this->senderName = $senderName;
//        $this->password = $password;
//    }


    public function send($message)
    {
        return "Notification  Send : $message via Mail";
    }

}
