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
     /**
     * Cette fonction retourne un tableau[cote]
     *
     * @return array|null
     */
    public function findCotes():array{
        return [
            '10 points' => ['10$' => 10],
            '12 points' => ['15$' => 12],
            '15 points' => ['20$' => 15],
            '16 points' => ['25$' => 16],
            '17 points' => ['30$' => 17],
            '18 points' => ['35$' => 18]
                    ]
       ;
    }

   /**
     * Cette fonction retourne un montant
     * @return int|null
     *
     */
    public function findMount($coteSearch){
         $cotes=[
            '10' => 10,
            '15' => 12,
            '20' => 15,
            '25' => 16,
            '30' => 17,
            '35' => 18
         ];
            foreach ($cotes as $key => $value) {
               if ($coteSearch==$value) {
                  return $key;
               }
            }        
    }
   
}

