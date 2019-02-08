<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;

class GenerateToken extends AbstractController
{
    public function generateToken(){

        $random = rtrim(strtr(base64_encode(random_bytes(64)), '+/', '-_'), '=');

        return $random;
    }

}