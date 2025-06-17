<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Prompts\Prompt;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart_Item extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'quantity',
        'product_id',
        'user_id'

    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
