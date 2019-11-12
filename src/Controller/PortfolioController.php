<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Portfolio;
use App\Form\PortfolioType;
use App\Repository\PortfolioRepository;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/portfolio", name="portfolio")
     */
    public function index(PortfolioRepository $repository)
    {
        return $this->render('portfolio/index.html.twig', [
            'portfolio' => $repository->findAll ()
        ]);
    }

  /**
   * @Route("/portfolio/new", name="new_portfolio")
   * @param Request $request
   * @IsGranted("ROLE_USER")
   * @return Response
   */
    public function new(Request $request)
    {
      $portfolio = new Portfolio();
      $image = new Images();

      $image -> setTitre ("titre de l'image");
      $portfolio->addImage ($image);
      $form = $this->createForm (PortfolioType::class, $portfolio);
      $form -> handleRequest ($request);

      if ($form -> isSubmitted () && $form->isValid ()) {
        $manager = $this->getDoctrine()->getManager();
        $manager->persist ($portfolio);
        $manager->flush ();

        $this->addFlash ('success', "Portfolio enregistré");

        $this->redirectToRoute ('admin_dashboard');
      }

      return $this->render ('portfolio/new.html.twig', [
        'portfolio' => $portfolio,
        'form' => $form->createView (),
      ]);
    }
}
