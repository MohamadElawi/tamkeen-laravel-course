<?php

namespace App\Http\Controllers\Api;

use App\Classes\admin;
use App\Classes\Manager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends ApiController
{
    public function login(){
//        $admin = new admin('mohamad_elawi' ,'123456789');

        $manager = new Manager('mohamad_elawi' ,'123456789');
        $manager->login('mohamad_elawi','123456789');
    }
}
