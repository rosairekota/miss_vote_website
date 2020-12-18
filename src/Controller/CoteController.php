<?php
namespace App\Controller;

use App\Entity\Competition;
use App\Entity\Cote;
use App\Entity\Search\CoteSearch;
use App\Entity\Candidat;
use App\Service\CoteService;
use App\Form\CoteSearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CoteRepository;

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
    public function cote(Candidat $candidat,Request $request,CoteRepository $repo):Response
    {
    //Etape 1: On initialise la session

        $session=$request->getSession();
        $votant=$session->get('votantSession',[]);
        
        $cotes=$session->get('cotesSession',[]);
         $datas=[];

       //Etape 2:  on verifie si le votant est dans la session

        if (!empty($votant)) {
           
            extract($votant);
               
               
         // Etape 3: on parcours les montants a payer pour obtenir les cotes corresponadants

            $coteSearch=new CoteSearch();
          $formCote=$this->createForm(CoteSearchType::class,$coteSearch);
          $formCote->handleRequest($request);
          if ($formCote->isSubmitted() && $formCote->isValid()) {
              $montant_paye=$this->coteService->findMount($coteSearch->getCote());
             
              $datas=[
                        'votant_id'     =>$votant->getId(),
                        'candidat_id'   =>$candidat->getId(),
                        'cote_votant'   =>$coteSearch->getCote(),
                        'montant_paye'  =>$montant_paye,
                        'nombrefoisvote' => $coteSearch->getNumberCotes()
                    ];
            
            

               for ($i=0; $i <$datas['nombrefoisvote']; $i++) { 

                $result=$repo->insertBySql($datas);
                  if ($result>0) {

                      $this->addFlash('success','L\'insertion reussi avec succès! Votre vote est validé!');
                        
                       return $this->redirectToRoute('candidat_show',['id'=>$datas['candidat_id']],301);
                    }
               }
               
             
            
           // $session->set('cotesSession',$datas);       
           // return $this->redirectToRoute('checkout_payment');
              
          }
        
        /*     OLD PART
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
                   

      // Etape 4: on initialise les cotes
      
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
            
                  


                //    // TEST2 DQL
              */
                   
            return $this->render('cote/vote.html.twig',[]);

           
        }
       
      
    }   
}
