<?php

namespace App\Traits ;

trait SluggableTrait{

    public $name ;

    public function generateSlug(){
        return strtolower(str_replace(' ','-' ,$this->name));
    }

    public abstract function setName();
}
