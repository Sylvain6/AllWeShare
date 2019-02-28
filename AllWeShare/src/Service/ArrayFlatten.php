<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArrayFlatten extends AbstractController
{
    function arrayFlatten(array $array) {
        $flatten = array();
        array_walk_recursive($array, function($value) use(&$flatten) {
            $flatten[] = $value;
        });

        return $flatten;
    }

}