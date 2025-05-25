<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\API\ApiController;
use App\Http\Requests\User\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends ApiController
{
    public function register(RegisterRequest $request){
        $user = User::create($request->validated());

        // create access token

        $token = $user->createToken('user_token')->plainTextToken;

        return $this->sendResponce(['access_token' => $token] , 'User Register successfully');
    }
}
