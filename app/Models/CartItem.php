<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Prompts\Prompt;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{

    protected $fillable = [
        'quantity',
        'product_id',
        'user_id' ,
        'color_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function color(){
        return $this->belongsTo(Color::class);
    }
}
