<?php

namespace App\Enums;

use Filament\Support\Colors\Color;

enum UserStatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case BLOCKED = 'blocked' ;


    public function color(){
        return match ($this){
            self::ACTIVE => Color::Green ,
            self::INACTIVE => Color::Red ,
            self::BLOCKED => Color::Indigo ,
        };
    }

}
