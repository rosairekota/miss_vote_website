<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Search\ThemeSearch;
use App\Form\CandidatType;
use App\Repository\CandidatRepository;
use App\Repository\ThemeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ThemeSearchType;

/**
 * @Route("/candidat")
 */
class CandidatController extends AbstractController
{
    
    /**
     * @Route("/", name="candidat_index", methods={"GET"})
     */
    public function index(Request $request,PaginatorInterface $pagination, ThemeRepository $themeRepository): Response
    {   $comp=$$request->session->get('compSession',[]);
        $themeSearch= new ThemeSearch();
        $form=$this->createForm(ThemeSearchType::class,$themeSearch);
         $form->handleRequest($request);

         $themes=$pagination->paginate($themeRepository->getPaginate(),$request->query->getInt('page',1),8);

     
        return $this->render('candidat/index.html.twig', [
            'themes' => $themes,
            'form'      =>$form->createView()
        ]);
    }
    /**
     *@Route("/theme", name="candidat_search")
     */
    public function searchByTheme(Request $request,PaginatorInterface $pagination, ThemeRepository $themeRepository){
        $themeSearch= new ThemeSearch();
        $form=$this->createForm(ThemeSearchType::class,$themeSearch);
         $form->handleRequest($request);

         $themes=$pagination->paginate($themeRepository->searchcandidateFromTheme($themeSearch),$request->query->getInt('page',1),4);
        return $this->render('candidat/index.html.twig', [
            'themes' => $themes,
            'form'      =>$form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="candidat_show", methods={"GET"})
     */
    public function show(Candidat $candidat): Response
    {
        return $this->render('candidat/show.html.twig', [
            'candidat' => $candidat,
        ]);
    }

}
