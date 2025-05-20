<?php

namespace App\Classes;

class User {

    public $first_name ;
    public $last_name ;
    public $age ;
    public $status ;

    public function __construct($first_name ,$last_name ,$age ,$status)
    {
        $this->first_name = $first_name ;
        $this->last_name = $last_name ;
        $this->age = $age ;
        $this->status = $status ;
    }


    public function isActive(){
        return $this->status == 'active';
    }

}