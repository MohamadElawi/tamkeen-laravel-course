<?php

namespace App\Console\Commands;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Console\Command;

class CartItemClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cartItem:clear {--days=} {--userId=}';

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

        $days = is_null($this->option('days')) ? 14 : $this->option('days') ;
        $userId = $this->option('userId');
        $user = User::find($userId);
//        if(!$user){
//            $this->error("User is not found");
//
//        }



        CartItem::where('created_at','<',now()->subDays($days))
            ->when($userId,function($query) use($userId){
                $query->where('user_id',$userId);
            })->delete();

        $this->info('command run successfully');
    }
}
