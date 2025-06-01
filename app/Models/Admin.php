<?php

namespace App\Models;

use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens,HasRoles;

    protected  $fillable = ['name' ,'email' ,'password' ,'phone','status'];

    protected $hidden = ['updated_at' ,'password'];

    protected $casts = [
        'status' => StatusEnum::class ,
        'password' => 'hashed' ,
        'created_at' => 'datetime:Y-m-d'
    ];

}
