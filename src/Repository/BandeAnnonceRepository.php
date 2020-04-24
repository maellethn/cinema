<?php

namespace App\Repository;

use App\Entity\BandeAnnonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BandeAnnonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method BandeAnnonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method BandeAnnonce[]    findAll()
 * @method BandeAnnonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BandeAnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BandeAnnonce::class);
    }

    // /**
    //  * @return BandeAnnonce[] Returns an array of BandeAnnonce objects
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
    public function findOneBySomeField($value): ?BandeAnnonce
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
