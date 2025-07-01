<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    use SoftDeletes;
    use HasTranslations;
    use HasFactory;
    protected $fillable=['user_id','order_number','total','sub_total','tax','status'];

    protected $casts = [
      'status' => OrderStatusEnum::class
    ];

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class,'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }



    public static function booted(){
        self::creating(function($order){
            $order->order_number = "Tamkeen_course" . rand(1111, 9999);
        });
    }

}
