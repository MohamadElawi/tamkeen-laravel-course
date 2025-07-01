<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';

    public function translate(){
        return match($this){
            self::PENDING => trans('pending') ,
            self::ACCEPTED => trans('accepted') ,
            self::REJECTED => trans('rejected')
        };
    }
}
