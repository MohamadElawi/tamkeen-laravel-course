<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Resources\Admin\Auth\LoginResource;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends ApiController
{
    public function login(LoginRequest $request){
        $credentials = $request->validated();
        $admin = Admin::where('email',$request->email)->first();

        if(!Hash::check($credentials['password'] ,$admin->password)){
            return $this->sendError('Invalid email or password');
        }

        $admin->accessToken = $admin->createToken('admin_token')->plainTextToken;

        return $this->sendResponce(LoginResource::make($admin) ,'Admin logged in successfully');
    }

    public function logout(){
        $admin = auth('admin')->user();

        $admin->currentAccessToken()->delete();

//        $admin->tokens()->delete();
        return $this->sendResponce(null , 'Admin Logged out successfully');
    }
}
