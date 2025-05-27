<?php

namespace App\Http\Controllers\User\Profile;

use App\Enums\Media\UserMediaEnum;
use App\Http\Requests\User\Profile\ProfileRequest;
use App\Http\Resources\User\User\UserResource;
use Illuminate\Http\Request;

class ProfileController
{
    public function show(){
        $user = auth('user')->user();

        return sendResponce(UserResource::make($user) ,'User Retrieved successfully');
    }

    public function update(ProfileRequest $request){
        $user = auth('user')->user();

        $user->update($request->validated());

        if($request->has('image')){
            $user->addMedia($request->file('image'))
                ->toMediaCollection(UserMediaEnum::MAIN_IMAGE->value);
        }

        return sendResponce(UserResource::make($user) ,'User Updated successfully');
    }
}
