<?php

namespace App\Classes;

use App\Traits\LoginTrait;

class admin
{
    use LoginTrait;

    private  $username ;

    private  $password ;

    public function __construct(string $username ,string $password)
    {
        $this->username = $username ;
        $this->password = $password ;
    }
}
