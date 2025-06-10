<?php


use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Profile\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('register',[RegisterController::class ,'register']);
Route::post('login',[LoginController::class ,'login']);
Route::get('logout',[LoginController::class ,'logout'])->middleware('auth:user');


Route::get('profile',[ProfileController::class ,'show'])->middleware('auth:user');
Route::post('profile',[ProfileController::class ,'update'])->middleware('auth:user');

Route::get('test-token',function(){
   return  auth()->user();
})->middleware(['auth:user','abilities:test-token,test-ability']);
