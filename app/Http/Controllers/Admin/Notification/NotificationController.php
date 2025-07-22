<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Classes\Notification;
use App\Http\Controllers\Controller;
use App\Interfaces\NotificationInterface;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(protected NotificationInterface $notification)
    {
    }

    public function __invoke()
    {
        return $this->notification->send('new user registered');
    }
}
