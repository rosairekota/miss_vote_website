<?php

namespace App\Repository;

use App\Entity\Candidat;
use App\Entity\Cote;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
/**
 * @method Cote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cote[]    findAll()
 * @method Cote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CoteRepository extends ServiceEntityRepository
{
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Cote::class);
        $this->em=$em;
    }
     public function findByCandidate(Candidat $candidat)
    {
           return  $this->createQueryBuilder('c')
                        ->andWhere('c.candidat_id = :val')
                        ->setParameter('val', $candidat->getId())
                        ->orderBy('c.id', 'ASC')
                        ->getQuery()
                        ->getResult()
        ;
    }

     /**
     * Cette fonction retourne un entier si l'insertion a bien reussi|null
     * @return int|null
     *
     */
     public function insertBySql(array $data=[]): ?int
    {
        $con=$this->em->getConnection();
             $sql="INSERT INTO cote(votant_id,candidat_id,cote_votant,montant_paye,datevote) VALUES(:votant_id, :candidat_id, :cote_votant, :montant_paye, NOW())";
        
            $con->prepare($sql);
           $result= $con->executeUpdate($sql,$data);
           return $result;
        
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
