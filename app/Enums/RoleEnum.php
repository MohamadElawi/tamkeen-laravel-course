<?php

namespace App\Enums;


enum RoleEnum : string
{
    case SUPER_ADMIN = 'super-admin' ;
    case ADMIN = 'admin' ;
    case USER = 'user' ;


    public function guard(){
        return match($this){
            self::SUPER_ADMIN => 'admin' ,
            self::ADMIN => 'admin' ,
            self::USER => 'user'
        };
    }
}
