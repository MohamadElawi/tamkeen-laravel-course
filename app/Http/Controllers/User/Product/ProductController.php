<?php

namespace App\Http\Controllers\User\Product;

use App\Enums\StatusEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Product\ProductSearchRequest;
use App\Http\Resources\User\Products\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    public function index(ProductSearchRequest $request){
//        $query = Product::whereStatus(StatusEnum::ACTIVE);

        // define a local scope
//        $query = Product::active();

        $query = Product::query();


        if($request->filled('search')){
            $search = $request->input('search');

            $query->where(function($q) use($search){
                $q->where('name->en','like',"%$search%")
                    ->orWhere('name->ar','like',"%$search%")
                    ->orWhereHas('categories',function($q)use($search){
                        $q->where('name->en','like',"%$search%")
                            ->orWhere('name->ar','like',"%$search%")
                            ->where('status',StatusEnum::ACTIVE);
                        // todo
                    });
            });

        }


        if($request->filled('color_id')){
            $query->whereHas('colors',function($q)use($request){
                $q->where('colors.id',$request->color_id)
                    ->where('status',StatusEnum::ACTIVE);
            });
        }

//        if($request->filled('price_from')){
//            $products->where('price','>=',$request->input('price_from'));
//        }
//
//        if($request->filled('price_to')){
//            $products->where('price','<=',$request->input('price_to'));
//        }


        if($request->filled('price_from') && $request->filled('price_to')){
            $query->priceFilter($request->input('price_from'),$request->input('price_to'));
        }

        $products =  $query
            ->with('categories' ,'colors','media')
            ->paginate($request->count) ;


        return $this->sendResponce(ProductResource::collection($products)
            ,'Product retrieved successfully',
        200 ,true);
    }

    public function show($id){
       return  $product = Product::active()->findOrFail($id);
    }
}
