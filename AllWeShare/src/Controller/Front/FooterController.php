<?php
/**
 * Created by PhpStorm.
 * User: antoine
 * Date: 06/02/2019
 * Time: 09:59
 */

namespace App\Controller\Front;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Routing\Annotation\Route;

class FooterController extends Controller
{

    /**
     * @Route("/cgu", name="cgu")
     */
    public function getCgu()
    {

        return $this->render('Front/footer/cgu.html.twig');
    }


}