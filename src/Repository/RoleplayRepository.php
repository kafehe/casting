<?php

namespace App\Repository;

use App\Entity\Roleplay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Roleplay|null find($id, $lockMode = null, $lockVersion = null)
 * @method Roleplay|null findOneBy(array $criteria, array $orderBy = null)
 * @method Roleplay[]    findAll()
 * @method Roleplay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleplayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Roleplay::class);
    }

    // /**
    //  * @return Roleplay[] Returns an array of Roleplay objects
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

    /*
    public function findOneBySomeField($value): ?Roleplay
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
