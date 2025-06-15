<?php

namespace App\Services;

use App\Enums\Media\ColorMediaEnum;
use App\Models\Color;

class ColorService extends BaseService
{
//    public function setModel()
//    {
//        $this->model = Color::class ;
//    }

    public function __construct()
    {
        $this->model = Color::class ;
    }

//    public function getAll(){
//
//    }


//    public function getAll($count = 10){
//        return Color::paginate($count);
//    }
//
//    public function create($data){
//        $color=  Color::create($data);
//
//        if(array_key_exists('image',$data)){
//            $color->addMedia($data['image'])
//                ->toMediaCollection(ColorMediaEnum::MAIN_IMAGE->value);
//        }
//
//        return $color ;
//    }
//
//    public function getColorById($id){
//        return  Color::findOrFail($id);
//    }
//
//    public function update($id ,$data){
//        $color = $this->getColorById($id);
//
//        $color->update($data);
//
//        if(array_key_exists('image',$data)){
//            $color->clearMediaCollection(ColorMediaEnum::MAIN_IMAGE->value);
//            $color->addMedia($data['image'])
//                ->toMediaCollection(ColorMediaEnum::MAIN_IMAGE->value);
//        }
//        return $color ;
//    }
//
//    public function delete($id){
//        $color = $this->getColorById($id);
//        $color->delete();
//    }

}
