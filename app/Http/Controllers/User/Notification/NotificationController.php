<?php

namespace App\Http\Controllers\User\Notification;

use App\Classes\Notification;
use App\Http\Controllers\Controller;
use App\Interfaces\NotificationInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __invoke(Notification $notification)
    {
        return $notification->send('new user registered');
    }

}
