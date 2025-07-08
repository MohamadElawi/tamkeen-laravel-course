<?php

namespace App\Http\Controllers\User\Favourite;

use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\UserFavourite;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class UserFavouriteController extends ApiController
{
    protected $user;

    public function __construct(
        protected ProductService $productService ,
        protected CategoryService $categoryService
    )
    {
        $this->user = auth('user')->user();
    }

    public function index(){
//        return  $this->user->favourites;
        return UserFavourite::where('favourable_type' ,get_class(new Product()))
            ->whereUserId($this->user->id)->with('favourable')->get();

    }


    public function addProductToFavourites($product_id)
    {
        $product = $this->productService->getProductById($product_id);

        if (!$product->favourites()->whereUserId($this->user->id)->exists()) {
            $product->favourites()->create([
                'user_id' => $this->user->id
            ]);

//            $this->user->favourites()->create([
//                'favourable_type' => get_class($product),
//                'favourable_id' => $product->id
//            ]);

        }

        return $this->sendResponce($product,
            'Product added to favourites successfully');
    }

    public function removeProductFromFavourites($product_id)
    {
        $product = $this->productService->getProductById($product_id);

        $product->favourites()->whereUserId($this->user->id)->delete();

        return $this->sendResponce($product,
            'Product removed from favourites successfully');
    }


    public function toggleCategoryFavourite($category_id)
    {
        $category = $this->categoryService->getCategoryById($category_id);

        $isExists = $category->favourites()->whereUserId($this->user->id)->exists();

        if($isExists){
            $category->favourites()->whereUserId($this->user->id)->delete();
            return $this->sendResponce($category,
                'Category removed from favourites successfully');
        }

        $category->favourites()->create([
            'user_id' =>$this->user->id
        ]);
        return $this->sendResponce($category,
            'Category added to favourites successfully');
    }
}
