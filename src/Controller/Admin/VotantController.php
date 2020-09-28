<?php

namespace App\Controller\Admin;

use App\Entity\Votant;
use App\Form\VotantType;
use App\Repository\VotantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class VotantController extends AbstractController
{
    /**
     * @Route("/", name="votant_index", methods={"GET"})
     */
    public function index(VotantRepository $votantRepository): Response
    {
        return $this->render('votant/index.html.twig', [
            'votants' => $votantRepository->findAll(),
        ]);
    }
    /**
    *@Route("/connexion/id",name="votant_login")
     */
    public function login(Candidat $candidat){

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

            return $this->redirectToRoute('votant_index');
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

    /**
     * @Route("/{id}/edit", name="votant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Votant $votant): Response
    {
        $form = $this->createForm(VotantType::class, $votant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('votant_index');
        }

        return $this->render('votant/edit.html.twig', [
            'votant' => $votant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="votant_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Votant $votant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$votant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($votant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('votant_index');
    }
}
