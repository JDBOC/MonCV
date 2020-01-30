<?php

namespace App\Controller;

use App\Entity\PasswordUpdate;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\PasswordUpdateType;
use App\Form\RegistrationType;
use App\Service\StatsService;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
      $username = $utils->getLastUsername ();


        return $this->render('account/login.html.twig', [
          'hasError' => $error !== null,

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
   * @param Request $request
   * @param ObjectManager $manager
   * @param UserPasswordEncoderInterface $encoder
   * @return Response
   */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
      $user = new User();
      $form = $this->createForm (RegistrationType::class, $user);
      $form->handleRequest ($request);

      if ($form->isSubmitted () && $form->isValid ()){

        $hash = $encoder->encodePassword ($user, $user->getHash ());
        $user->setHash ($hash);

        $manager->persist ($user);
        $manager->flush ();

        $this->addFlash ('success', "Inscription validée");

        return $this->redirectToRoute ('index');
      }

      return $this->render ('account/registration.html.twig', [
        'form' => $form->createView ()
      ]);
    }

  /**
   * Permet d'éditer le profil du compte
   *
   * @Route("/account/profile", name="account_profile")
   * @Security("is_granted('ROLE_USER')")
   * @return Response
   */
    public function profile(Request $request, ObjectManager $manager) {
      $user = $this->getUser ();
      $form = $this->createForm (AccountType::class, $user);
      $form->handleRequest ($request);

      if ($form->isSubmitted () && $form->isValid ()) {
        $manager->persist ($user);
        $manager->flush ();
        $this->addFlash ('success', "Modification effectuée !");

        return $this->redirectToRoute ('admin_dashboard');
      }

return $this->render ('account/profile.html.twig', [
  'form' => $form->createView ()
]);
    }

  /**
   * @Route("/account/password-update", name="password_update")
   * @Security("is_granted('ROLE_USER')")
   */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager) {
      $passwordUpdate = new PasswordUpdate();

      $user = $this->getUser ();

      $form = $this->createForm (PasswordUpdateType::class, $passwordUpdate);
      $form->handleRequest ($request);

      if ($form->isSubmitted ()&& $form->isValid ()) {
        if(!password_verify ($passwordUpdate->getOldPassword (), $user->gethash())){

          $form->get ('oldPassword')->addError (new FormError("Le mot de passe que vous avez tapé n'est pas correct"));
        }
        else
        {
          $newPassword = $passwordUpdate->getNewPassword ();
          $hash = $encoder->encodePassword($user, $newPassword);

          $user -> setHash($hash);
          $manager -> persist ($user);
          $manager->flush ();
        }
        $this->addFlash ('success', "Mot de passe modifié !");
        return $this->redirectToRoute ('admin_dashboard');
      }

      return $this->render ('account/updatePassword.html.twig', [
        'form' => $form->createView ()
      ]);
    }
}
