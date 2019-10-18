<?php

namespace App\Controller;

use App\Entity\Experiences;
use App\Form\Experiences1Type;
use App\Form\ExperiencesType;
use App\Repository\ExperiencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/experiences")
 */
class ExperiencesController extends AbstractController
{
    /**
     * @Route("/", name="experiences_index", methods={"GET"})
     */
    public function index(ExperiencesRepository $experiencesRepository): Response
    {
        return $this->render('experiences/index.html.twig', [
            'experiences' => $experiencesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="experiences_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $experience = new Experiences();
        $form = $this->createForm(ExperiencesType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($experience);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('experiences/new.html.twig', [
            'experience' => $experience,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="experiences_show", methods={"GET"})
     */
    public function show(Experiences $experience): Response
    {
        return $this->render('experiences/show.html.twig', [
            'experience' => $experience,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="experiences_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Experiences $experience): Response
    {
        $form = $this->createForm(ExperiencesType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('experiences_index');
        }

        return $this->render('experiences/edit.html.twig', [
            'experience' => $experience,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="experiences_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Experiences $experience): Response
    {
        if ($this->isCsrfTokenValid('delete'.$experience->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($experience);
            $entityManager->flush();
        }

        return $this->redirectToRoute('experiences_index');
    }
}
