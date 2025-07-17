<?php


use App\Exceptions\TestException;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\Api\UserController;
use App\Jobs\AJob;
use App\Jobs\BJob;

use App\Models\Product;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::controller(ProductController::class)->group(function () {
//     Route::get('/products', "index");
//     Route::post('/products/store',  "store");
//     Route::put('/products/{id}', "update");
//     Route::delete('/products/{id}', "destroy");
//     Route::get('/products/{id?}', "show");
// });
Route::resource('products', ProductController::class)->missing(function (Request $request) {
    return response()->json(['error Product not found. '], 484);
});

Route::resource('categories', CategoryController::class);


Route::resource('orders', OrderController::class);

Route::get('retrieve_active_records', [ProductController::class, 'retrieve_active_records']);

Route::get('soft_deleted_records', [ProductController::class, 'soft_deleted_records']);

Route::delete('products/force-delete/{product_id}', [ProductController::class, 'forceDestroy']);

Route::post('products/update-color/{product_id}', [ProductController::class, 'updateProductColors']);
Route::get('products/clear-media/{product_id}', [ProductController::class, 'clearMedia']);

Route::get('only_soft_deleted_records', [ProductController::class, 'only_soft_deleted_records']);

Route::get('restore_product/{id}', [ProductController::class, 'restore_product']);

Route::get('getName/{id}', [ProductController::class, 'getName']);

Route::get('users', [UserController::class, 'index']);


Route::get('get-products-by-categoryId/{category_id}', [CategoryController::class, 'getProductsByCategory']);

Route::get('login', [LoginController::class, 'login']);


Route::apiResource('colors', ColorController::class);

Route::post('test-storage', function (Request $request) {
//    dd($request->file('file'));

//    $storage = Storage::put('image.jpg' ,file_get_contents($request->file('file')));


//    $storage = Storage::exists('image.jpg');
//
//    Storage::download('image.jpg');
//
//    dd($storage);

//      $product = Product::with('media')->first();
//
//     $product->addMedia($request->file('file'))
//        ->toMediaCollection();

//    return $product->getMedia();
});


Route::get('UnAuthenticated', function () {

    return response()->json([
        "success" => true,
        "message" => "UnAuthenticated"
    ]);
})->name('UnAuthenticated');


Route::get('test-job',function(){
//    // send a mail
//    sleep(5);
//
//
//    // processing image
//    sleep(3);

    dispatch(new AJob());
    dispatch(new BJob());

   return 'done';
});



Route::get('test-log',function(){
    Log::info('Order created',['order_id' => 5]);
//    Log::debug('');
});


Route::get('test-exception',function(){

//    try{
//        throw new ('error happened');
//    }catch (Exception $exception){
//        return response()->json($exception->getMessage(), $exception->getCode());
//    }
});


Route::get('test-cache',function(){
    Cache::put('name','mohamad');

    Cache::get('name');
    Cache::put('name','ahmad');
    Cache::put('email','mohamad@gmail.com');
////    Cache::forget('name');
//    Cache::flush();
//    return [Cache::get('name') ,Cache::get('email')];


    $products = Cache::remember('products',600 ,function(){
        return Product::get();
    });

    return $products;
});

