<?php


use App\Http\Controllers\API\CartItemsController;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Category\CategoryController;
use App\Http\Controllers\User\Favourite\UserFavouriteController;
use App\Http\Controllers\User\Order\OrderController;
use App\Http\Controllers\User\Product\ProductController;
use App\Http\Controllers\User\Profile\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register',[RegisterController::class ,'register']);
Route::post('login',[LoginController::class ,'login']);

Route::middleware('auth:user')->group(function(){
    Route::get('logout',[LoginController::class ,'logout']);


    Route::get('profile',[ProfileController::class ,'show']);
    Route::post('profile',[ProfileController::class ,'update']);

    Route::post('verify-account',[LoginController::class ,'verifyAccount']);


    Route::get('categories',[CategoryController::class ,'index']);
    Route::get('categories/{id}',[CategoryController::class ,'show']);

    Route::get('products',[ProductController::class ,'index']);
    Route::get('products/{id}',[ProductController::class ,'show']);


    Route::resource('cart-items', CartItemsController::class);

    Route::apiResource('orders',OrderController::class)->except('destroy','update');

    Route::get('products/{product_id}/add-to-favourite',[UserFavouriteController::class ,'addProductToFavourites']);
    Route::get('products/{product_id}/remove-from-favourite',[UserFavouriteController::class ,'removeProductFromFavourites']);

    Route::get('categories/{category_id}/toggle-favourite',[UserFavouriteController::class ,'toggleCategoryFavourite']);
    Route::get('get-favourites',[UserFavouriteController::class ,'index']);

});


Route::get('test-token',function(){
   return  auth()->user();
})->middleware(['auth:user','abilities:test-token,test-ability']);
