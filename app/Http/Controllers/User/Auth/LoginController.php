<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\User\Auth\LoginRequest;
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

       $user->access_token = $user->createToken('user_token')->plainTextToken ;

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
}
