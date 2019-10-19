<?php

  namespace App\Controller;

  use App\Entity\User;
  use App\Service\StatsService;
  use Doctrine\Common\Persistence\ObjectManager;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\Routing\Annotation\Route;
  use Symfony\Component\HttpFoundation\Response;

  class AdminDashboardController extends AbstractController
  {
    /**
     * @Route("/admin", name="admin_dashboard")
     * @param ObjectManager $manager
     * @param StatsService $statsService
     * @return Response
     */
    public function index(ObjectManager $manager, StatsService $statsService): Response
    {
      $stats = $statsService->getStats();

      return $this->render('admin/dashboard/index.html.twig', [
        'stats' => $stats,

      ]);
    }
  }
