<?php

namespace App\Http\Controllers\API;

use App\Classes\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends ApiController
{

    private $users = [
        ['first_name' => 'mohamad', 'last_name' => 'elawi', 'age' => 26, 'status' => 'active'],
        ['first_name' => 'mohamad', 'last_name' => 'elawi', 'age' => 26, 'status' => 'active'],
        ['first_name' => 'ahmad', 'last_name' => 'elawi', 'age' => 20, 'status' => 'inactive'],
        ['first_name' => 'obada', 'last_name' => 'elawi', 'age' => 25, 'status' => 'inactive'],
    ];


    public function index()
    {

//     $users = [
//        new User('mohamad', 'elawi',  26,  'active') ,
//        new User('ahmad', 'elawi',  26,  'inactive') ,
//        new User('obada', 'elawi',  26,  'active') ,
//    ];

     $users = collect($this->users);
        // Option 1:
        // 1. Add full_name to each user
        // 2. Filter active users
        // 3. Remove duplicates


        return     $userNames = $users->map(function ($user) {
            $user['full_name'] = $user['first_name'] . '-' . $user['last_name'];
            return $user;
        })->filter(function($user){
            return $user['status'] == 'active';
        })->unique();


        // Option 2: Using Higher Order Messages (HOM) to:
        // 1. Filter active users
        // 2. Reset keys with values()
        // 3. Map to get only first names
//        return $usersCollection = collect($users)->filter->isActive()->values()->map->first_name;

        // dd(get_class($users));
    }
}
