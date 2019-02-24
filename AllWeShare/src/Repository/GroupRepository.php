<?php

namespace App\Repository;

use App\Entity\Group;
use App\Entity\User;
use App\Service\ArrayFlatten;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Group::class);
    }

    public function findGroupsContains(User $user){
        $groups = $this->findBy(['owner' => $user]);
        $arrayFlatten = New ArrayFlatten();
        foreach (range(1, 3) as $i) {
            if($this->findBy(['user'.$i => $user])) {
                $groups2[] = $this->findBy(['user' . $i => $user]);
            }
        }
        $flatten = $arrayFlatten->arrayFlatten($groups2);
        $mergedGroup = array_merge($groups, $flatten);
        return $mergedGroup;
    }

    // /**
    //  * @return Group[] Returns an array of Group objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Group
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
