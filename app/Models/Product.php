<?php

namespace App\Models;

use App\Enums\Media\ProductMediaEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Product extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;
    use HasFactory;
    use SoftDeletes;
    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'price',
        'description',
        'slug' ,
        'status' ,
        'quantity'
    ];

    protected  $casts = [
        'status' => StatusEnum::class
    ];


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products');
    }
//    public function getPriceAttribute($price)
//    {
//        return '$' . number_format($price, 2);
//    }
    public function getNameAttribute($name)
    {
        return ucfirst($name);
    }
    public function setNameAttribute($name)
    {

        $this->attributes['name'] = ucfirst($name);
    }


    public function colors(){
        return $this->belongsToMany(Color::class ,'product_colors');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(ProductMediaEnum::MAIN_IMAGE->value)
            ->useDisk(ProductMediaEnum::MAIN_IMAGE->disk())
            ->singleFile();

        $this->addMediaCollection(ProductMediaEnum::GALLERY->value)
            ->useDisk(ProductMediaEnum::GALLERY->disk());
    }

}
