<?php

namespace App\Repository;

use App\Entity\Casting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Request;
use http\QueryString;

/**
 * @method Casting|null find($id, $lockMode = null, $lockVersion = null)
 * @method Casting|null findOneBy(array $criteria, array $orderBy = null)
 * @method Casting[]    findAll()
 * @method Casting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CastingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Casting::class);
    }





    public function  getCastingById (Request $request)
    {
        $qb = $this->getEntityManager()->createQuery(
            "SELECT c APP\ENTITY\Casting c  WHERE c.id = ?", [$request.query.id]
        );
        return $qb->getResult();
    }

    public function  getCastingByType ()
    {
        $qb = $this->createQueryBuilder('c')
            ->where("c.type_cast like '%FILMS%' ")
            ->getQuery();

        return $qb->getResult();
    }

    public function  getCastingVideo ()
    {
        $qb = $this->getEntityManager()->createQuery(
            "SELECT c FROM APP\ENTITY\Casting c  WHERE c.type_cast LIKE '%VIDEO%' "
        );
        return $qb->getResult();
    }

    public function getCastingModel () {

        $qb = $this->getEntityManager()->createQuery(
            "SELECT c FROM APP\ENTITY\Casting c  WHERE c.type_cast LIKE '%Modeling%' "
        );
        return $qb->getResult();
    }

    public function getCastingTheatre () {

        $qb = $this->getEntityManager()->createQuery(
            "SELECT c FROM APP\ENTITY\Casting c  WHERE c.type_cast LIKE '%Theatre%' "
        );
        return $qb->getResult();
    }

    public function getCastingVoiceover () {

        $qb = $this->getEntityManager()->createQuery(
            "SELECT c FROM APP\ENTITY\Casting c  WHERE c.type_cast LIKE '%Voiceover%' "
        );
        return $qb->getResult();
    }

    // /**
    //  * @return Casting[] Returns an array of Casting objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Casting
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
