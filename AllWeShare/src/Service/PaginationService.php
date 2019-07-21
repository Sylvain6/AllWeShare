<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\Tools\Pagination\Paginator;
use InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaginationService extends AbstractController{


    public function finWithPagination($page, $repository, $where, $parameters = null){

        if (!is_numeric($page)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $page est incorrecte (valeur : ' . $page . ').'
            );
        }

        if ($page < 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas');
        }

        if (!is_numeric(4)) {
            throw new InvalidArgumentException(
                'La valeur de l\'argument $nbMaxParPage est incorrecte (valeur : ' . 4 . ').'
            );
        }

        if( $where !== null ){
            $qb = $repository->createQueryBuilder('p') //p
            ->where($where);
        }
        else{
            $qb = $repository->createQueryBuilder('p'); //p
            //->where($where);
        }
        //'CURRENT_DATE() >= p.createdAt'
            if( !empty( $parameters ) ){
                $qb->setParameter( $parameters[0], $parameters[1] );
            }
            $qb->orderBy('p.createdAt', 'DESC');


        //throw new \Exception( $qb );
        $query = $qb->getQuery();

        $premierResultat = ($page - 1) * 4;
        $query->setFirstResult($premierResultat)->setMaxResults(4);
        $paginator = new Paginator($query);

        if ( ($paginator->count() <= $premierResultat) && $page != 1) {
            throw new NotFoundHttpException('La page demandée n\'existe pas.'); // page 404, sauf pour la première page
        }

        return $paginator;
    }

}
