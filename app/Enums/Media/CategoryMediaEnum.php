<?php

namespace App\Enums\Media;

enum CategoryMediaEnum : string
{
    case MAIN_IMAGE = 'main-image';

    public function disk(){
        return match ($this){
            self::MAIN_IMAGE => 'main_image',
        };
    }
} 