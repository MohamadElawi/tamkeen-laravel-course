<?php

namespace App\Providers;


use App\Events\UserRegistered;
use App\Listeners\AssignDefualtPermission;
use App\Listeners\SendNotification;
use App\Listeners\SendWelcomeMail;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
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



       Authenticate::redirectUsing(function(Request $request){
        if($request->is('admin/*')){
            return redirect()->route('admin.login');
        }
        return redirect()->route('login');
       });
    }
}
