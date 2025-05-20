<?php

namespace App\Traits ;


trait  LoginTrait{

    public function login($username ,$password){
        if($this->checkCredentials($username ,$password))
            echo "You are been successfully logged in";

        else{
            echo  "invalid username or password";
        }
    }



    private function checkCredentials($username , $password){
        return $this->username == $username && $this->password == $password ;
    }
}
