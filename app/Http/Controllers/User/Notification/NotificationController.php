<?php

namespace App\Http\Controllers\User\Notification;

use App\Classes\Notification;
use App\Http\Controllers\Controller;
use App\Interfaces\NotificationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function __construct(protected NotificationInterface $notification)
    {
    }

    public function __invoke()
    {
        $response = Http::post('google.com',[]);



        return $this->notification->send('new user registered');
    }

}
