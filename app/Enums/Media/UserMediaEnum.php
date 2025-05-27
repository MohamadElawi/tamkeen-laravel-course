<?php

namespace App\Enums\Media;

enum UserMediaEnum : string
{
    case  MAIN_IMAGE = 'profile-image' ;


    public static function disk(){
       return 'user';
    }
}
