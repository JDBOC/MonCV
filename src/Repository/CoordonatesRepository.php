<?php

namespace App\Repository;

use App\Entity\Coordonates;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Coordonates|null find($id, $lockMode = null, $lockVersion = null)
 * @method Coordonates|null findOneBy(array $criteria, array $orderBy = null)
 * @method Coordonates[]    findAll()
 * @method Coordonates[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoordonatesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Coordonates::class);
    }

    // /**
    //  * @return Coordonates[] Returns an array of Coordonates objects
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
    public function findOneBySomeField($value): ?Coordonates
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
