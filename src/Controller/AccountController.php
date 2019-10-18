<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
  /**
   * @Route("/login", name="account_login")
   * @param AuthenticationUtils $utils
   * @return Response
   */
    public function login(AuthenticationUtils $utils)
    {
      $error = $utils->getLastAuthenticationError ();
        return $this->render('account/login.html.twig', [
          'hasError' => $error !== null
        ]);
    }

  /**
   * @Route("/logout", name="account_logout")
   */
    public function logout()
    {

    }

  /**
   * @Route("/register", name="account_register")
   * @return Response
   */
    public function register(Request $request, ObjectManager $manager) {
      $user = new User();
      $form = $this->createForm (RegistrationType::class, $user);
      $form->handleRequest ($request);

      if ($form->isValid () && $form->isSubmitted ()){
        $manager->persist ($user);
        $manager->flush ();
      }

      return $this->render ('account/registration.html.twig', [
        'form' => $form->createView ()
      ]);
    }
}
