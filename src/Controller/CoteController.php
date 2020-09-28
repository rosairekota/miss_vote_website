<?php
namespace App\Controller;

use App\Entity\Competition;
use App\Entity\Cote;
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
     *@Route("/coter", name="cotes_add")
     */
    public function payement(Request $request,EntityManagerInterface $em):Response
    {
    //Etape 1: On initialise la session

        $session=$request->getSession();
        $votant=$session->get('votantSession',[]);
        $candidat=$session->get('candidatSession',[]);
        $comp=$session->get('compSession',[]);
        

       //Etape 2:  on verifie si le votant et le candidat sont dans la session

        if (!empty($votant)&&!empty($candidat)) {
            extract($candidat);
            extract($votant);
                $coteObtenu=0;
                $montantAPayer=1;
         // Etape 3: on parcours les montants a payer pour obtenir les cotes corresponadants

            $cotes=$this->coteService->findCotes();
            foreach ($cotes as $cote => $point) {
            if ($request->request->getInt('cote')==$cote) {
                $coteObtenu=$point;
                $montantAPayer=$cote*($request->request->getInt('numberCotes')==0?'1':$request->request->getInt('numberCotes'));
                    // dd('montant unitaire ='.$request->request->getInt('cote'),'cote ='. $coteObtenu,'montant a payer='.$montantAPayer);
                    // $coteEntity->setCandidat($candidat);
                    // dd($coteEntity->getCandidat());
            }
        }

        // Etape 4: on initialise les cotes
         $coteEntity =new Cote();
        $com=new Competition();
        $com->setId(\uniqid());

         $coteEntity->setCandidat($candidat)
                          ->setVotant($votant)
                          ->setCompetition(null);
                          ;  if ($coteEntity->getVotant()->getCategory()=='votant') {
                                 $coteEntity->setCoteVotant($coteObtenu);
                             }
                             else{
                                  $coteEntity->setCoteJury($coteObtenu);
                             }
                           $coteEntity->setMontantPaye($montantAPayer);
                          
                    $em->persist($candidat);
                    $em->persist($votant);
                    $em->persist($coteEntity);
                    $em->flush();
            return $this->render('cote/vote.html.twig',['cote'=>$coteEntity]);
        }
       
      
        return null;
    }
}
