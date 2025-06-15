<?php

namespace App\Services;

use App\Enums\Media\ColorMediaEnum;
use App\Models\Color;

abstract class BaseService
{
    protected $model ;

    abstract public function __construct();
//    abstract function setModel();

    public function getAll($count = 10){
        return $this->model::paginate($count);
    }

    public function create($data){
        $modelInstance =  $this->model::create($data);

        if(array_key_exists('image',$data)){
            $modelInstance->addMedia($data['image'])
                ->toMediaCollection(ColorMediaEnum::MAIN_IMAGE->value);
        }

        return $modelInstance ;
    }

    public function getById($id){
        return  $this->model::findOrFail($id);
    }

    public function update($id ,$data){
        $modelInstance = $this->getById($id);

        $modelInstance->update($data);

        if(array_key_exists('image',$data)){
            $modelInstance->clearMediaCollection(ColorMediaEnum::MAIN_IMAGE->value);
            $modelInstance->addMedia($data['image'])
                ->toMediaCollection(ColorMediaEnum::MAIN_IMAGE->value);
        }
        return $modelInstance ;
    }

    public function delete($id){
        $modelInstance = $this->getById($id);
        $modelInstance->delete();
    }
}
