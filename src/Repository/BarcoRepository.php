<?php

namespace App\Repository;

use App\Entity\Barco;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Barco|null find($id, $lockMode = null, $lockVersion = null)
 * @method Barco|null findOneBy(array $criteria, array $orderBy = null)
 * @method Barco[]    findAll()
 * @method Barco[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BarcoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Barco::class);
    }

    // /**
    //  * @return Barco[] Returns an array of Barco objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Barco
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
