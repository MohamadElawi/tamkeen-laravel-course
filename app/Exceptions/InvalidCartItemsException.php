<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class InvalidCartItemsException extends Exception
{
//    public function report(){
//        Log::driver('order')->error($this->getMessage());
//    }

//    public function render(){
//        return response()->json($this->getMessage());
//    }

    public function context(): array{
        $user = auth('web')->user();
        return ['user_id' => $user->id , 'user_name' => $user->name];
    }
}
