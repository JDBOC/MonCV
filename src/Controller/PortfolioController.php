<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Portfolio;
use App\Form\PortfolioType;
use App\Repository\ImagesRepository;
use App\Repository\PortfolioRepository;


use Doctrine\Common\Persistence\ObjectManager;
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
    public function index(PortfolioRepository $repository, ImagesRepository $imagesRepository)
    {
        return $this->render('portfolio/index.html.twig', [
            'portfolio' => $repository->findAll (),
            'images' => $imagesRepository->findAll (),
        ]);
    }

  /**
   * @Route("/portfolio/new", name="new_portfolio")
   * @param Request $request
   * @IsGranted("ROLE_USER")
   * @return Response
   */
    public function new(Request $request, ObjectManager $manager)
    {
      $portfolio = new Portfolio();
      $image = new Images();


      $portfolio->addImage ($image);
      $form = $this->createForm (PortfolioType::class, $portfolio);
      $form -> handleRequest ($request);

      if ($form -> isSubmitted () && $form->isValid ()) {
        foreach ($portfolio->getImages () as $image){
          $image->setPortfolio ($portfolio);
          $manager->persist ($image);
        }
        //$manager = $this->getDoctrine()->getManager();

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
