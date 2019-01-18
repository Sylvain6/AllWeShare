<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Post::class);
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */

    public function search($title)
    {
        return $this->createQueryBuilder('p')
            ->where('p.title LIKE :title')
            ->setParameter('title', $title)
            ->orderBy('p.title', 'ASC')
            ->setFirstResult(10)
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function increaseLikes($id): void
    {
        $this->getEntityManager()
             ->createQuery("UPDATE AppBundle\Entity\Post post SET post.nb_like = nb_like + 1 WHERE post.id = ".$id)
             ->execute();
    }

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
