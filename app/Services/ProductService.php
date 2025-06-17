<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function create(array $data){
        return Product::create($data);
    }


    public function getProductById($id , $withTrashed = false){
       return Product::when($withTrashed ,fn($q) => $q->withTrashed())
            ->findOrFail($id);

//        Product::when($withTrashed ,function($q){
//            return $q->withTrashed();
//        })->findOrFail($id);
    }

    public function update($id , array $data){
        $product = $this->getProductById($id);

        $product->update($data);
        return $product ;
    }

    public function updateProductCategories($product ,$category_ids){
        $product->categories()->sync($category_ids );
    }
}
