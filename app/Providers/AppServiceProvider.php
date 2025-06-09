<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Http\Request;
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
       RedirectIfAuthenticated::redirectUsing(function(){
        dd('d');
       });

       Authenticate::redirectUsing(function(Request $request){
        if($request->is('admin/*')){
            return redirect()->route('admin.login');
        }
        return redirect()->route('login');
       });
    }
}
