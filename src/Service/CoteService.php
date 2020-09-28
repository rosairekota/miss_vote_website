<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * undocumented class
 */
class CoteService
{
   
    /**
     * @var SessionInterface
     */
    private  $session;

    public function __construct(SessionInterface $session)
    {
        $this->session=$session;
    }
    /**
     * Cette fonction retourne un tableau[votant,cote]
     * @return array
     *
     * @return array|null
     */
    public function add($coteObtenu,$numberCotes):?array{

        
        foreach ($this->findCotes() as $cote => $point) {
           if ($coteObtenu==$cote) {
               $coteObtenuV=$point;
               $montantAPayer=$cote*$numberCotes==0?'1':$numberCotes;
               
            return [
                'montantUnitaire '=>$cote,
                'cote'            =>$coteObtenuV,
                'montantTotApayer' =>$montantAPayer
            ];
           }

    return [
                'montantUnitaire '=>$cote,
                'cote'            =>$coteObtenu,
               
            ];;
    }
    }

    public function findCotes():array{
        return [
            10=>'10', 
            15=>'12' ,
            20=>'15',
            25=>'16',
            30=>'17',
            35=>'18'
        ];
    }

}

