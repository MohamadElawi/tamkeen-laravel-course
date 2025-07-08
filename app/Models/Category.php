<?php

namespace App\Models;

use App\Enums\Media\CategoryMediaEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{
    use SoftDeletes;
    use HasTranslations;
    use HasFactory;
    use InteractsWithMedia;

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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(CategoryMediaEnum::MAIN_IMAGE->value)
            ->useDisk(CategoryMediaEnum::MAIN_IMAGE->disk())
            ->singleFile();
    }

    public static function booted()
    {
        static::creating(function ($category) {
//            dd($category);
        });
    }

    public function favourites(){
        return $this->morphMany(UserFavourite::class , 'favourable');
    }
}
