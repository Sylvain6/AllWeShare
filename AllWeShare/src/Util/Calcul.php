<?php

namespace App\Util;

class Calcul
{
    public function add($a, $b){
        return $a + $b;
    }

    public function sub($a, $b){
        return $a - $b;
    }

    public function mul($a, $b){
        return $a * $b;
    }

    public function div($a, $b){
        if($b == 0)
            return 'lel t con';

        return $a / $b;
    }

    public function avg($a, $b){
        return ($a + $b) / 2;
    }
}