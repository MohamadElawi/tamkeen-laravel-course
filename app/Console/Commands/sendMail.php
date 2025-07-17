<?php

namespace App\Console\Commands;

use App\Jobs\SendWelcomeMailJob;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;

class sendMail extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:send {userId} {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('userId');
        $user = User::findOrFail($userId);

        if($this->option('queue')){
            dispatch(new SendWelcomeMailJob($user));
        }
        else
            Mail::to($user->email)->send(new WelcomeMail($user));
    }

    protected function promptForMissingArgumentsUsing(): array
    {
        return [
            'userId' => 'Which user ID should receive the mail?',
        ];
    }
}
