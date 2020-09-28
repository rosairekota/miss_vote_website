<?php

namespace App\Controller;

use App\Entity\Votant;
use App\Entity\Candidat;
use App\Form\VotantType;
use App\Form\LoginVotantType;
use App\Repository\VotantRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Encoder\EncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/votant")
 */
class VotantController extends AbstractController
{
    private SessionInterface $session;
    private  $encoder;
    public function __construct(SessionInterface $sessionInterface,UserPasswordEncoderInterface $encoder)
    {
        $this->session=$sessionInterface;
         $this->encoder=$encoder;
    }
    /**
     * @Route("/voter/{id}", name="votant_vote", methods={"GET"})
     */
    public function voted(Candidat $candidat): Response
    {
        $votes=$this->session->get('votantSession',[]);
        $cand=$this->session->get('candidatSession',[]);

        if (empty($votes['votant'])) {
            return $this->redirectToRoute('votant_login',['id'=>$candidat->getId()],301);
        }
        //unset($votes['votant']);
        //unset($cand['candidat']);
        $cotes=[
            10=>'10', 
            15=>'12' ,
            20=>'15',
            25=>'16',
            30=>'17',
            35=>'18'
        ];
        return $this->render('votant/vote.html.twig', [
            'cotes' =>$cotes,
        ]);
    }
    /**
    *@Route("/connexion/{id}",name="votant_login")
     */
    public function login(Candidat $candidat,Request $request,VotantRepository $repo){
     //$this->addFlash('warning','Au utilisateur de ce nom est reconnu');
        $votantSession=$this->session->get('votantSession',[]);
         $candSession=$this->session->get('candidatSession',[]);

        $votant=new Votant();
        $form=$this->createForm(LoginVotantType::class,$votant);
         $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) {
         
            $pwdHashed=sha1($votant->getMotdepass());
            $votantRepo=$repo->findOneBy(['email'=>$votant->getEmail(),'motdepass'=>$pwdHashed]);
           
            if (!empty($votantRepo)) {
                $votantSession=['votant'=>$votantRepo];
                $candidatSession=['candidat'=>$candidat];
                $this->session->set('votantSession',$votantSession);
                $this->session->set('candidatSession',$candidatSession);

                return $this->redirectToRoute('votant_vote',['id'=>$candidat->getId()],301);
            }
            else{
                      $this->addFlash('warning', 'Oups! vous n\'etes pas trouvé dans notre système. Veuillez recommencer.');
            }

        }

       
         return $this->render('votant/login.html.twig', [
             'candidat' =>$candidat,
             'form'     =>$form->createView()
        ]);
    }
    /**
     * @Route("/new", name="votant_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $votant = new Votant();
        $form = $this->createForm(VotantType::class, $votant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($votant);
            $entityManager->flush();

            return $this->redirectToRoute('votant_login');
        }

        return $this->render('votant/new.html.twig', [
            'votant' => $votant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="votant_show", methods={"GET"})
     */
    public function show(Votant $votant): Response
    {
        return $this->render('votant/show.html.twig', [
            'votant' => $votant,
        ]);
    }

}
