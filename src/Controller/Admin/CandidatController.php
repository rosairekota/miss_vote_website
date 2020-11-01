<?php

namespace App\Controller\Admin;

use App\Entity\Candidat;
use App\Form\CandidatType;
use App\Repository\CandidatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class CandidatController extends AbstractController
{
    /**
     * @Route("/candidat", name="admin_candidat_index", methods={"GET"})
     */
    public function index(CandidatRepository $candidatRepository): Response
    {
        return $this->render('admin/candidat/index.html.twig', [
            'candidats' => $candidatRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new/candidat", name="admin_candidat_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $candidat = new Candidat();
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidat);
            $entityManager->flush();

            return $this->redirectToRoute('admin_candidat_index');
        }

        return $this->render('admin/candidat/new.html.twig', [
            'candidat' => $candidat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/candidat/{id}", name="admin_candidat_edit", methods={"GET"})
     */
    public function show(Candidat $candidat): Response
    {
        return $this->render('admin/candidat/show.html.twig', [
            'candidat' => $candidat,
        ]);
    }

    /**
     * @Route("/candidat/{id}/edit", name="admin_candidat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Candidat $candidat): Response
    {
        $form = $this->createForm(CandidatType::class, $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_candidat_index');
        }

        return $this->render('admin/candidat/edit.html.twig', [
            'candidat' => $candidat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/candidat/{id}", name="candidat_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Candidat $candidat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$candidat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($candidat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_candidat_index');
    }
}
