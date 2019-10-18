<?php

  namespace App\Controller;

  use App\Entity\Contact;
  use App\Form\ContactType;
  use App\Notification\ContactNotification;
  use App\Repository\CoordonatesRepository;

  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;


  class ContactController extends AbstractController
  {


    /**
     * @Route("/message/new", name="message")
     * @param Request $request
     * @param ContactNotification $notification
     * @param CoordonatesRepository $coordonatesRepository
     * @return Response
     */
    public function contact(Request $request , ContactNotification $notification , CoordonatesRepository $coordonatesRepository)
    {
      $contact = new Contact();
      $form = $this->createForm ( ContactType::class , $contact );
      $form->handleRequest ( $request );

      if ($form->isSubmitted () && $form->isValid ()) {
        $notification->notify ( $contact );
        $this->addFlash ( 'success' , 'Votre message a été envoyé' );
        return $this->redirectToRoute ( 'index' );
      }
      return $this->render ( 'contact/contact.html.twig' , [
        'coordonates' => $coordonatesRepository->findAll () ,
        'formContact' => $form->createView () ,
      ] );
    }


  }