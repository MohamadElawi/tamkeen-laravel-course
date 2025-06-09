<?php

namespace App\Enums;

enum StatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function translate(){
        return match($this){
            self::ACTIVE => trans('Active') ,
            self::INACTIVE => trans('Inactive')
        };
    }
}
