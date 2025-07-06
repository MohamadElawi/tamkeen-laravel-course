<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use App\Mail\SendInvoiceMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Mail;
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

        self::created(function($order){

        });

        self::updating(function ($order){
//            if($order->getOriginal('status') == OrderStatusEnum::PENDING &&
//                $order->status == OrderStatusEnum::ACCEPTED){
//                $userEmail = $order->user->email;
//                Mail::to($userEmail)->send(new SendInvoiceMail($order));
//            }

        });

        self::updated(function($order){
//
        });

        self::deleted(function(){

        });


    }

}
