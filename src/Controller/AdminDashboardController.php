<?php

  namespace App\Controller;

  use App\Entity\User;
  use App\Service\StatsService;
  use Doctrine\Common\Persistence\ObjectManager;
  use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
  use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\Routing\Annotation\Route;
  use Symfony\Component\HttpFoundation\Response;

  class AdminDashboardController extends AbstractController
  {
    /**
     * @Route("/admin", name="admin_dashboard")
     * @return Response
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {
      $entityManager = $this->getDoctrine ()->getManager ();
      $totalComp = $entityManager->createQuery('SELECT COUNT(c) FROM App\Entity\Competences c')->getSingleScalarResult();
      $totalForm = $entityManager->createQuery('SELECT COUNT(f) FROM App\Entity\Formations f')->getSingleScalarResult();
      $totalExp = $entityManager->createQuery('SELECT COUNT(e) FROM App\Entity\Experiences e')->getSingleScalarResult();

      return $this->render('admin/dashboard/index.html.twig', [
        'stats' => compact ('totalComp', 'totalForm', 'totalExp')

      ]);
    }
  }
