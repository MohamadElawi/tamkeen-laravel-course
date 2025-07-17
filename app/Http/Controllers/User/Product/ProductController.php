<?php

namespace App\Http\Controllers\User\Product;

use App\Enums\StatusEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Product\ProductSearchRequest;
use App\Http\Resources\User\Products\ProductResource;
use App\Models\Product;
use App\Models\Scopes\ActiveScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends ApiController
{
    public function index(ProductSearchRequest $request){
//        $query = Product::whereStatus(StatusEnum::ACTIVE);

        // define a local scope
//        $query = Product::active();


//        $products = Cache::remember('products' ,now()->addMinutes(45) ,function() use($request){
//
//        });
        $query = Product::query()
//            ->withoutGlobalScope(ActiveScope::class)
            ->active()
            ->search($request->input('search'))
            ->colorFilter($request->input('color_id'))
            ->priceFilter($request->input('price_from'),$request->input('price_to'));

         $products =  $query
            ->with('categories' ,'colors','media')
            ->paginate($request->count) ;


        return $this->sendResponce(ProductResource::collection($products)
            ,'Product retrieved successfully',
        200 ,true);
    }

    public function show($id){
         $product = Product::active()
             ->with(['colors' => function($q){
                 $q->whereStatus(StatusEnum::ACTIVE);
             }])
             ->findOrFail($id);
         return $this->sendResponce(ProductResource::make($product),
             'Product retrieved successfully');
    }
}
