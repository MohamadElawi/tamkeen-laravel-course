<?php


use App\Enums\StatusEnum;
//use App\Http\Controllers\CategoryController;
//use App\Http\Controllers\ProductController_old;
//use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    dd( (int) config('taxes.tax_rate'));

    dump(  config('app.locale'));

    config(['app.locale' => 'ar']);

    dump(config('app.locale'));


//    $product = Product::where('status',StatusEnum::ACTIVE)->first();
//
//    dd($product->status->translate());
//
//    $cases = StatusEnum::cases();
//    foreach ($cases as $case){
//        dump($case->translate());
//    }

//    return $cases;

//    return view('welcome');

});

//Route::resource('products', ProductController::class);


