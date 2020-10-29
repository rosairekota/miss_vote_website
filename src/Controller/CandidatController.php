<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Form\ThemeSearchType;
use App\Form\CandidatSearchType;
use App\Entity\Search\ThemeSearch;
use App\Repository\ThemeRepository;
use App\Repository\CandidatRepository;
use App\Repository\CoteRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CandidatController extends AbstractController
{
    private $cote;
    public function __construct(CoteRepository $cote)
    {
        $this->cote=$cote;
        
    }
    
    /**
     * @Route("/", name="candidat_index", methods={"GET"})
     */
    public function index(Request $request,PaginatorInterface $pagination, CandidatRepository $candRepository): Response
    {   //$comp=$$request->session->get('compSession',[]);
        $candidatSearch= new Candidat();
        $form=$this->createForm(CandidatSearchType::class,$candidatSearch);
         $form->handleRequest($request);

         $candidats=$pagination->paginate($candRepository->getPaginate(),$request->query->getInt('page',1),8);
        //$this->cote->findByCandidate($candidatSearch);
     
        return $this->render('candidat/index.html.twig', [
            'candidats' => $candidats,
            'form'      =>$form->createView()
        ]);
    }
    /**
     *@Route("/candidat/recherche", name="candidat_search")
     */
    public function searchByTheme(Request $request,PaginatorInterface $pagination, CandidatRepository $candRepository){
        
        $candidatSearch= new Candidat();
        $form=$this->createForm(CandidatSearchType::class,$candidatSearch);
         $form->handleRequest($request);
         $candidat=$candRepository->searchcandidateFromTheme($candidatSearch);
         $candidats=$pagination->paginate($candidat,$request->query->getInt('page',1),8);

     
        return $this->render('candidat/index.html.twig', [
            'candidats' => $candidats,
            'form'      =>$form->createView()
        ]);
    }

    /**
     * @Route("/candidat/{id}", name="candidat_show", methods={"GET"})
     */
    public function show(Candidat $candidat): Response
    {
        return $this->render('candidat/show.html.twig', [
            'candidat' => $candidat,
        ]);
    }

    /**
     * @Route("/candidat/{id}/voir-les-votants", name="candidat_countVote", methods={"GET"})
     */
    public function view(Candidat $candidat): Response
    {
        return $this->render('candidat/voted.html.twig', [
            'candidat' => $candidat,
        ]);
    }

}
