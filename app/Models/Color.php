<?php

namespace App\Models;

use App\Enums\Media\ColorMediaEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Color extends Model implements HasMedia
{

    use InteractsWithMedia ;
    protected $table = 'colors';

    protected $fillable = [
        'title' ,
        'status'
    ];

    protected $hidden = [
        'updated_at'
    ];

    protected $casts = [
        'status' => StatusEnum::class
    ];

    public function products(){
        return $this->belongsToMany(Product::class ,'product_colors');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(ColorMediaEnum::MAIN_IMAGE->value)
            ->useDisk(ColorMediaEnum::disk())
            ->singleFile();
    }
}

