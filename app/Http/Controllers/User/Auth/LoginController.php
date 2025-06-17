<?php

namespace App\Http\Controllers\User\Auth;

use App\Enums\UserStatusEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Requests\User\Auth\LoginRequest;
use App\Http\Requests\User\Auth\VerifyAccountRequest;
use App\Http\Resources\User\User\LoginResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends ApiController
{
    public function login(LoginRequest $request){
        $data = $request->validated();

        $user = User::where('email',$data['email'])->first();

        if(!Hash::check($data['password'] ,$user->password )){
            return $this->sendError('Invalid credentials');
        }

        if(is_null($user->email_verified_at)){
            return $this->sendError('Please Verify Your account and try later');
        }

       $user->access_token = $user->createToken('user_token',['test-token' ,'test-ability'])->plainTextToken ;

        return $this->sendResponce(LoginResource::make($user),'User Logged in successfully');
    }

    public function logout(){
        $user = auth('user')->user();
//        return $user->tokens()->get();

        // delete all tokens
//        $user->tokens()->delete() ;

        // remove received token
        $user->currentAccessToken()->delete();

        return $this->sendResponce(null ,'user logout successfully');
    }

    public function verifyAccount(VerifyAccountRequest $request){
        $user = User::where('email',$request->input('email'))->first();

        if($user->verification_code != $request->verification_code){
            return $this->sendError('verification code is invalid');
        }

        $user->update(['email_verified_at' => now() , 'status' => UserStatusEnum::ACTIVE]);
        return $this->sendResponce(null,'your email is verified successfully');
    }
}
