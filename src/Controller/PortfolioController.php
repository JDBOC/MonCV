<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Portfolio;
use App\Entity\Upload;
use App\Form\PortfolioType;
use App\Repository\PortfolioRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/portfolio")
 */
class PortfolioController extends AbstractController
{
    /**
     * @Route("/", name="portfolio_index", methods={"GET"})
     */
    public function index(PortfolioRepository $portfolioRepository): Response
    {
        return $this->render('portfolio/index.html.twig', [
            'portfolios' => $portfolioRepository->findAll(),
        ]);
    }

  /**
   * @Route("/new", name="portfolio_new", methods={"GET","POST"})
   * @IsGranted("ROLE_USER")
   * @param Request $request
   * @return Response
   */
    public function new(Request $request): Response
    {
        $portfolio = new Portfolio();

        $image = new Image();
        $image ->setUrl ('http://placehold.it/400x200');

      $image2 = new Image();
      $image2 ->setUrl ('http://placehold.it/400x200');

        $portfolio->addImage ($image)
                  ->addImage ($image2);


        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            foreach ($portfolio->getImages () as $image) {
              $image -> setPortfolio ($portfolio);
              $entityManager->persist ($image);
            }
            $entityManager->persist($portfolio);

            $entityManager->flush();

            return $this->redirectToRoute('portfolio_index');
        }

        return $this->render('portfolio/new.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="portfolio_show", methods={"GET"})
     */
    public function show(Portfolio $portfolio): Response
    {
        return $this->render('portfolio/show.html.twig', [
            'portfolio' => $portfolio,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="portfolio_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request, Portfolio $portfolio): Response
    {
        $form = $this->createForm(PortfolioType::class, $portfolio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('portfolio_index');
        }

        return $this->render('portfolio/edit.html.twig', [
            'portfolio' => $portfolio,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="portfolio_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request, Portfolio $portfolio): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portfolio->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($portfolio);
            $entityManager->flush();
        }

        return $this->redirectToRoute('portfolio_index');
    }
}
