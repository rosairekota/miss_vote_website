<?php

namespace App\Repository;

use App\Entity\Cote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Cote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cote[]    findAll()
 * @method Cote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cote::class);
    }

    // /**
    //  * @return Cote[] Returns an array of Cote objects
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
    public function findOneBySomeField($value): ?Cote
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
