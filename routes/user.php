<?php


use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register',[RegisterController::class ,'register']);
Route::post('login',[LoginController::class ,'login']);
Route::get('logout',[LoginController::class ,'logout'])->middleware('auth:user');


Route::get('test-token',function(){
   return  auth()->user()->password;
})->middleware('auth:user');
