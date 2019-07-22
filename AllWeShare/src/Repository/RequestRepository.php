<?php

namespace App\Repository;

use App\Entity\Request;
use App\Entity\User;
use App\Repository\PostRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Service\ArrayFlatten;

/**
 * @method Request|null find($id, $lockMode = null, $lockVersion = null)
 * @method Request|null findOneBy(array $criteria, array $orderBy = null)
 * @method Request[]    findAll()
 * @method Request[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RequestRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Request::class);
    }


    // /**
    //  * @return Request[] Returns an array of Request objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function findByOwner(User $user){
        $arrayflatten = new ArrayFlatten();
        $postRepository = $this
            ->getEntityManager()
            ->getRepository('App\Entity\Post');
        $posts = $postRepository->findBy(['author' => $user]);
        
        $requests = [];
        foreach ($posts as $post){
            $requests[] = $this->findBy(['post' => $post, 'status' => 'PENDING']);
        }
        
        $result=$arrayflatten->arrayFlatten($requests);
        return $result;
    }
    
    /*public function findRequestByOwner( $array )
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.post_id = :post AND r.status = :status')
            ->setParameter('post', $array['post'])
            ->setParameter('status', $array['status'])
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }*/
       
}
