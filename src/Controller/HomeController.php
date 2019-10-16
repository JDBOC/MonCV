<?php

  namespace App\Controller;

  use App\Entity\User;
  use App\Repository\ExperiencesRepository;
  use App\Repository\FormationsRepository;
  use App\Repository\UserRepository;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;

  class HomeController extends AbstractController
  {
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(UserRepository $repo,
                          ExperiencesRepository $experiencesRepository,
                          FormationsRepository $formationsRepository
  )
    {

      $user = $this->getDoctrine ()->getRepository ( User::class );


      return $this->render ( 'home/index.html.twig' , [
        'user' => $repo->findOneBy ( [] ),
        'experiences' => $experiencesRepository->findAll (),
        'formations' => $formationsRepository->findAll ()
      ] );
    }
  }
