<?php

namespace App\Traits ;

trait SluggableTrait{

    public $name ;

    public function generateSlug($name){

//        $name = !is_null($name) ? $name  : $this->name ;
        return strtolower(str_replace(' ','-' ,$name));
    }

//    public abstract function setName();
}
