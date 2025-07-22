<?php

namespace App\Providers;


use App\Classes\Notification;
use App\Events\UserRegistered;
use App\Http\Controllers\Admin\Admin\AdminController;
use App\Http\Controllers\Admin\Notification\NotificationController;
use App\Http\Controllers\User\Notification\NotificationController as UserNotificationController;
use App\Interfaces\NotificationInterface;
use App\Listeners\AssignDefualtPermission;
use App\Listeners\SendNotification;
use App\Listeners\SendWelcomeMail;
use App\Models\Order;
use App\Models\User;
use App\Observers\OrderObserver;
use App\Services\MailNotificationService;
use App\Services\SMSNotificationService;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        $this->app->bind(NotificationInterface::class, function(){
//            $senderName = 'mohamad' ;
//            $password = '123456' ;
//
//            return new MailNotificationService($senderName ,$password);
//        });


        $this->app->bind('notification', SMSNotificationService::class);

        // dependency injection
//        $this->app->singleton(MailNotificationService::class);

//        $this->app->bind(MailNotificationService::class ,function(){
//            $senderName = 'mohamad' ;
//            $password = '123456' ;
//
//            return new MailNotificationService($senderName ,$password);
//        });

        $this->app->when(NotificationController::class)
                ->needs(NotificationInterface::class)
                ->give(MailNotificationService::class);


        $this->app->when(UserNotificationController::class)
                ->needs(NotificationInterface::class)
                ->give(SMSNotificationService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        Event::listen(UserRegistered::class ,
//                AssignDefualtPermission::class);
//
//        Event::listen(UserRegistered::class ,
//            SendNotification::class);
//
//        Event::listen(UserRegistered::class ,
//            SendWelcomeMail::class);


        Order::observe(OrderObserver::class);

    //    Authenticate::redirectUsing(function(Request $request){
    //     if($request->is('admin/*')){
    //         return route('admin.login');
    //     }
    //     return route('login');
    //    });

//        Route::bind('user',function($value){
//            return User::where('email',$value)->firstOrFail();
//        });
    }

}
