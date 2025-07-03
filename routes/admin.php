<?php


use App\Http\Controllers\Admin\Admin\AdminController;
use App\Http\Controllers\Admin\Admin\PermissionController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Order\OrderController;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login']);

Route::middleware(['auth:admin','role:admin|super-admin'])->group(function () {

    Route::get('logout', [LoginController::class, 'logout']);

    Route::apiResource('admins', AdminController::class);


    Route::get('admins/toggle-status/{id}', [AdminController::class, 'toggleStatus']);

    Route::get('permissions',[PermissionController::class ,'index']);
    Route::post('permissions/{admin_id}',[PermissionController::class ,'store']);

    Route::apiResource('orders',OrderController::class)->only('index','show');
});

