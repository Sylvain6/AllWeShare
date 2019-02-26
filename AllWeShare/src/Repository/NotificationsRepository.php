<?php

namespace App\Repository;

use App\Entity\Notifications;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Notifications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notifications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notifications[]    findAll()
 * @method Notifications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Notifications::class);
    }

    // /**
    //  * @return Notifications[] Returns an array of Notifications objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */


    public function getAllNotificationFromUser( User $user )
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.id_receiver = :user_id AND n.is_seen = false')
            ->setParameter( 'user_id', $user->getId() )
            ->orderBy('n.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
