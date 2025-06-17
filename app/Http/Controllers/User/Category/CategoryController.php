<?php

namespace App\Http\Controllers\User\Category;

use App\Enums\StatusEnum;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\Categories\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function index(){
      $categories = Category::where('status',StatusEnum::ACTIVE->value)
          ->whereHas('products' ,function ($q){
              $q->where('status',StatusEnum::ACTIVE->value);
          })
          ->paginate();

      return $this->sendResponce(CategoryResource::collection($categories) ,'Categories retrieved successfully',
          200 ,
          true);
    }

    public function show($id){
        $category = Category::where('status',StatusEnum::ACTIVE->value)->findOrFail($id);

        return $this->sendResponce(CategoryResource::make($category) ,'Categories retrieved successfully');
    }
}
