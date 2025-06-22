<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;


use  App\Models\Product;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use SoftDeletes;
    use HasTranslations;
    use HasFactory;

    public $translatable = ['name'];
    protected $fillable = [
        'name',
        'slug',
        'status'
    ];

    protected $casts = [
        'status' => StatusEnum::class
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_products');
    }

    /*  */

    public static function booted()
    {
        static::creating(function ($category) {
//            dd($category);
        });
    }
}
