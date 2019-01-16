<?php

namespace App\Controller\Back;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        //throw new Exception( json_encode( "ok") );
        return $this->render('Back/index_back.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }
}
