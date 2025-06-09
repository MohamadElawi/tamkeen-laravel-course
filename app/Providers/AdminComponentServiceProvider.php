<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AdminComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::component('admin-layout', \App\View\Components\Layouts\AdminLayout::class);
        Blade::component('admin.sidebar', \App\View\Components\Admin\Sidebar::class);
    }
} 