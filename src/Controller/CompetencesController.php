<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Form\CompetencesType;
use App\Repository\CompetencesRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/competences")
 */
class CompetencesController extends AbstractController
{
    /**
     * @Route("/", name="competences_index", methods={"GET"})
     */
    public function index(CompetencesRepository $competencesRepository): Response
    {
        return $this->render('competences/index.html.twig', [
            'competences' => $competencesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="competences_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
        $competence = new Competences();
        $form = $this->createForm(CompetencesType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competence);
            $entityManager->flush();

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('competences/new.html.twig', [
            'competence' => $competence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competences_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(Competences $competence): Response
    {
        return $this->render('competences/show.html.twig', [
            'competence' => $competence,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="competences_edit", methods={"GET","POST"})
     * @Security("is_granted('ROLE_USER')")   // and user === competence.getUser()
     */
    public function edit(Request $request, Competences $competence): Response
    {
        $form = $this->createForm(CompetencesType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_dashboard');
        }

        return $this->render('competences/edit.html.twig', [
            'competence' => $competence,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competences_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Competences $competence): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competence->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($competence);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_dashboard');
    }
}
