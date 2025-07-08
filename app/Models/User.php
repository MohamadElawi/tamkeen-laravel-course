<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Media\UserMediaEnum;
use App\Enums\UserStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens, InteractsWithMedia, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_code',
        'status',
        'email_verified_at'
    ];

    protected $guard_name = 'user';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatusEnum::class
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(UserMediaEnum::MAIN_IMAGE->value)
            ->singleFile()
            ->useDisk(UserMediaEnum::disk());
    }


    protected static function booted()
    {
        self::creating(function ($user) {
            $user->verification_code = rand(111111, 999999);
        });

        self::created(function ($user) {
            // send a verification mail
        });
    }

    public function favourites(){
        return $this->hasMany(UserFavourite::class);
    }

}
