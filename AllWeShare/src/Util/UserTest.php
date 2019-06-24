<?php

namespace App\Util;


class UserTest
{
    private $email;

    private $lastname;

    private $firstname;

    private $age;

    public function __construct($email, $fn, $ln, $age)
    {
        $this->email = $email;
        $this->firstname = $fn;
        $this->lastname = $ln;
        $this->age = $age;
    }

    public function isValid() {
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) && $this->lastname && is_string($this->lastname) && $this->firstname && is_string($this->firstname) && $this->age > 13 ){
            return true;
        }
        return false;
    }

    public function getAge(){
        return $this->age;
    }
}