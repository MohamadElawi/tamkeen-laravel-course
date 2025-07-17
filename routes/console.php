<?php

use Illuminate\Console\Command;
use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('user:test',function(){
    echo "hello user";
})->everyFourHours();



Schedule::command('cartItem:clear --days=7')->daily();
