<?php

namespace App\Services;

use App\Models\Category;
use App\Traits\SluggableTrait;

class CategoryService
{
    use  SluggableTrait;

    public function getAll(){
        return Category::with('products')->paginate();
    }

    public function getCategoryById($id){

        return  Category::findOrFail($id);
    }

    public function create(array $data){
        $category = new Category();

        $category->setTranslations('name', [
            'en' => $data['name_en'],
            'ar' => $data['name_ar']
        ]);

        $category->slug = $this->generateSlug($data['name_en']);

        $category->save();

        return $category ;
    }

    public function update($id , $data){
        $category = $this->getCategoryById($id);
        $category->update($data);
        return $category ;
    }

    public function delete($id){
        $category = $this->getCategoryById($id);
        $category->delete();
    }
}
