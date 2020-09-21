<?php

namespace App\Repository;

use App\Entity\Votant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Votant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Votant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Votant[]    findAll()
 * @method Votant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VotantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Votant::class);
    }

    // /**
    //  * @return Votant[] Returns an array of Votant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Votant
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
