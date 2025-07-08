<?php

namespace App\Models;

use App\Enums\Media\ProductMediaEnum;
use App\Enums\StatusEnum;
use App\Models\Scopes\ActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
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
        'slug',
        'status',
        'quantity'
    ];

    protected $casts = [
        'status' => StatusEnum::class
    ];

    ############### Relations #####################

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products');
    }


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(ProductMediaEnum::MAIN_IMAGE->value)
            ->useDisk(ProductMediaEnum::MAIN_IMAGE->disk())
            ->singleFile();

        $this->addMediaCollection(ProductMediaEnum::GALLERY->value)
            ->useDisk(ProductMediaEnum::GALLERY->disk());
    }


    ################### local scopes ################

    public function scopeActive($query )
    {
        return $query->where('status', StatusEnum::ACTIVE);
    }

    public function scopePriceFilter($query, $from, $to)
    {

        if(!$from && !$to)
            return $query ;


        $query->whereBetween('price', [$from, $to]);
    }

    public function scopeSearch($query ,$search){
        if(!$search)
            return $query ;

       return $query->where(function($q) use($search){
                $q->where('name->en','like',"%$search%")
                    ->orWhere('name->ar','like',"%$search%")
                    ->orWhereHas('categories',function($q)use($search){
                        $q->where('name->en','like',"%$search%")
                            ->orWhere('name->ar','like',"%$search%")
                            ->where('status',StatusEnum::ACTIVE);
                        // todo
                    });
            });
    }


    public function scopeColorFilter($builder ,$colorId){
        if(!$colorId)
            return $builder ;

        return    $builder->whereHas('colors',function($q)use($colorId){
            $q->where('colors.id',$colorId)
                ->where('status',StatusEnum::ACTIVE);
        });
    }

    ################### methods ###################

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


    protected static function boot()
    {
        parent::boot();

//        self::addGlobalScope(ActiveScope::class);
    }

    protected static function booted()
    {

        self::created(function ($product) {

        });

        self::updated(function ($product) {
            //
        });

        self::deleted(function ($product) {
            //
        });

        self::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }


    public function favourites(){
        return $this->morphMany(UserFavourite::class ,'favourable');
    }

}
