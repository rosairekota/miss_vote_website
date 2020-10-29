<?php

namespace App\Repository;

use App\Entity\Candidat;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Candidat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Candidat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Candidat[]    findAll()
 * @method Candidat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CandidatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Candidat::class);
    }

     public function getPaginate()
    {
        $query=$this->getQueryBuiler();

        return $query->getQuery();
           
    }
     public function searchcandidateFromTheme(Candidat $candidat)
    {
        $query=$this->getQueryBuiler();
         if ($candidat->getNom()) {
            $query=$query->andWhere('c.nom=:val')
                         ->setParameter('val',$candidat->getNom());
                         
         }
        
       // $id=settype($candidat->getId(),'integer');

         if ($candidat->getId()) {
            $query=$query->andWhere('c.id=:val')
                         ->setParameter('val',$candidat->getId());
                         
         }
        return $query->orderBy('c.id','DESC')
                    ->getQuery();
        ;
    }
    /**
     * 
     * @return QueryBuilder|null
     */
    private function getQueryBuiler(): ?QueryBuilder
    {
        return $this->createQueryBuilder('c');
            
        
    }

    // /**
    //  * @return Candidat[] Returns an array of Candidat objects
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
    public function findOneBySomeField($value): ?Candidat
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
