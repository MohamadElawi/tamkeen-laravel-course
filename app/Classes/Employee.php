<?php

namespace App\Classes;

class Employee
{
    private  $username ;

    private  $password ;

    public function __construct(string $username ,string $password)
    {
        $this->username = $username ;
        $this->password = $password ;
    }
}
