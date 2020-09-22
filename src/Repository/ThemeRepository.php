<?php

namespace App\Repository;

use App\Entity\Search\ThemeSearch;
use App\Entity\Theme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Theme|null find($id, $lockMode = null, $lockVersion = null)
 * @method Theme|null findOneBy(array $criteria, array $orderBy = null)
 * @method Theme[]    findAll()
 * @method Theme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Theme::class);
    }

    // /**
    //  * @return Theme[] Returns an array of Theme objects
    //  */
    
    public function getPaginate()
    {
        $query=$this->getQueryBuiler();

        return $query->getQuery();
           
    }
     public function searchcandidateFromTheme(ThemeSearch $themeSearch)
    {
        $query=$this->getQueryBuiler();
         if ($themeSearch->getTitle()) {
            $query=$query->andWhere('t.titre=:val')
                         ->setParameter('val',$themeSearch->getTitle())
                         ->orderBy('t.id','DESC')
                         ->getQuery();
         }
        return $query;
        ;
    }
    /**
     * 
     * @return QueryBuilder|null
     */
    private function getQueryBuiler(): ?QueryBuilder
    {
        return $this->createQueryBuilder('t');
            
        
    }
    
    /*
    public function findOneBySomeField($value): ?Theme
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
