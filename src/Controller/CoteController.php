<?php
namespace App\Controller;

use App\Entity\Competition;
use App\Entity\Cote;
use App\Entity\Candidat;
use App\Service\CoteService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *@Route("/cotes")
 */
class CoteController extends AbstractController
{

    private $coteService;
    public function __construct(CoteService $coteService){
        $this->coteService=$coteService;
    }

     /**
     *@Route("/coter/{id}", name="cote_add")
     */
    public function cote(Candidat $candidat,Request $request,EntityManagerInterface $em):Response
    {
    //Etape 1: On initialise la session

        $session=$request->getSession();
        $votant=$session->get('votantSession',[]);
        
        $cotes=$session->get('cotesSession',[]);
        

       //Etape 2:  on verifie si le votant est dans la session

        if (!empty($votant)) {
           
            extract($votant);
                $coteObtenu=0;
                $montantAPayer=1;
                $datas=[];
         // Etape 3: on parcours les montants a payer pour obtenir les cotes corresponadants

            
            foreach ($this->coteService->findCotes() as $cote => $point) {
                if ($cote==$request->request->get('cote')) {
                    $coteObtenu=$point;
                    
                    $montantAPayer=$cote*($request->request->getInt('numberCotes')==0?'1':$request->request->getInt('numberCotes'));

                  
                }
        }
         $datas=[
                        'votant_id'     =>$votant->getId(),
                        'candidat_id'   =>$candidat->getId(),
                        'cote_votant'   =>$coteObtenu,
                        'montant_paye'  =>$montantAPayer
                    ] ;  

                    
             $session->set('cotesSession',$datas);       
            return $this->redirectToRoute('checkout_payment');
                //     // TEST1 SQL
                   

    /*    // Etape 4: on initialise les cotes
      
         $coteEntity =new Cote();
       
      
            dd($votant->getNom());
         $coteEntity->setCandidat($candidat)
                          ->setVotant($votant)
                          ;  if ($coteEntity->getVotant()->getCategory()=='votant') {
                                 $coteEntity->setCoteVotant($coteObtenu);
                             }
                             else{
                                  $coteEntity->setCoteJury($coteObtenu);
                             }
                           $coteEntity->setMontantPaye($montantAPayer);
                          
                   
                    if ($coteEntity!=null) {

                    //    $em->persist($candidat);
                    //    $em->persist($votant);
                       $em->persist($coteEntity);
                       $em->flush();
                      dd($coteEntity);
                    }
            */
                  


                //    // TEST2 DQL
                //  dd('c\'est null ');
                   
           // return $this->render('cote/vote.html.twig',[]);
        }
       
      
    }   
}
