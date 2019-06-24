<?php

namespace App\Util;


class ProductTest
{
    private $name;

    private $user;

    public function __construct($name, UserTest $user)
    {
        $this->name = $name;
        $this->user = $user;
    }

    public function isValid() {
        return !empty($this->name)
            && is_string($this->name)
            && $this->user->isValid();
    }

    public function getOwner(){
        return $this->user;
    }
}