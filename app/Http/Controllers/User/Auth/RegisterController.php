<?php

namespace App\Http\Controllers\User\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\User\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends ApiController
{
    public function register(RegisterRequest $request){

        DB::beginTransaction();

//        DB::transaction(function() use($request){

        try{
            $data = $request->validated();



            $user = User::create($data);


            // by helper function
            event(new UserRegistered($user));

            $token = $user->createToken('user_token')->plainTextToken;

            DB::commit();

        }catch(\Exception $e){
            DB::rollBack();
        }

//        });



//        UserRegistered::dispatch($user);

        // send verification mail to user

        // assign default role , permissions

        // send notification to admin

        // create access token



        return $this->sendResponce(['access_token' => $token] , 'User Register successfully');
    }
}
