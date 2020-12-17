<?php

namespace App\Controller;

use App\Entity\Votant;
use App\Entity\Candidat;
use App\Form\VotantType;
use App\Service\CoteService;
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
    private CoteService $coteservice;
    public function __construct(CoteService $coteservice,SessionInterface $sessionInterface,UserPasswordEncoderInterface $encoder)
    {
        $this->session=$sessionInterface;
         $this->encoder=$encoder;
         $this->coteservice=$coteservice;
    }
    /**
     * @Route("/voter/{id}", name="votant_vote", methods={"GET"})
     */
    public function voted(Candidat $candidat): Response
    { 
        $votes=$this->session->get('votantSession',[]);
       

        if (empty($votes['votant'])) {
            return $this->redirectToRoute('votant_login',['id'=>$candidat->getId()],301);
        }
         
        return $this->render('votant/vote.html.twig', [
            'cotes' =>$this->coteservice->findCotes(),
            'candidat'=>$candidat
        ]);
        
    }
    /**
    *@Route("/connexion/{id}",name="votant_login")
     */
    public function login(Candidat $candidat,Request $request,VotantRepository $repo){
     //$this->addFlash('warning','Au utilisateur de ce nom est reconnu');
      
        $votantSession=$this->session->get('votantSession',[]);
        // $candSession=$this->session->get('candidatSession',[]);
         
        $votant=new Votant();
        $form=$this->createForm(LoginVotantType::class,$votant);
         $form->handleRequest($request);

        if ($form->isSubmitted()&&$form->isValid()) {
         
            $pwdHashed=sha1($votant->getMotdepass());
            $votantRepo=$repo->findOneBy(['email'=>$votant->getEmail(),'motdepass'=>$pwdHashed]);
           
            if (!empty($votantRepo)) {
                $votantSession=['votant'=>$votantRepo];
               
                $this->session->set('votantSession',$votantSession);
               

               // on redirege le votant vers l'action voted()
                
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
     * @Route("/deconnexion", name="votant_logout", methods={"GET"})
     */
    public function logout(): Response
    { 
        $votes=$this->session->get('votantSession',[]);
       

        if (!empty($votes['votant'])) {
            unset($votes);
            session_destroy();
            return $this->redirectToRoute('candidat_index');
        }
         
        return $this->render('votant/vote.html.twig', []);
        
    }
    /**
     * @Route("/new/{id}", name="votant_new", methods={"GET","POST"})
     */
    public function new(Request $request,Candidat $candidat): Response
    {
       
        $votant = new Votant();
        $form = $this->createForm(VotantType::class, $votant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pwdHashed=sha1($votant->getMotdepass());
            $votant->setMotdepass($pwdHashed);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($votant);
            $entityManager->flush();

            return $this->redirectToRoute('votant_login',['id'=>$candidat->getId()],301);
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
