<?php


use App\Http\Controllers\Admin\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:admin')->group(function () {

    Route::get('logout', [LoginController::class, 'logout']);

    Route::apiResource('admins', AdminController::class);


    Route::get('admins/toggle-status/{id}', [AdminController::class, 'toggleStatus']);
});

