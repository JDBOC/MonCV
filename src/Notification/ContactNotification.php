<?php

  namespace App\Notification;

  use App\Entity\Contact;
  use Twig\Environment;


  class ContactNotification {

    /*
     * @var \Swift_Mailer
     */
    private $mailer;

    /*
    * @var Environment
    */
    private $renderer;


    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
      $this->mailer = $mailer;
      $this->renderer = $renderer;
    }

    public function notify(contact $contact):void
    {

      $message = (new \Swift_Message( 'Nouveau message' ))
        ->setFrom ( 'jdboccara@gmail.com' )
        ->setTo ( 'jdboccara@mailo.com' )
        ->setReplyTo ( $contact->getEmail () )
        ->setBody ( $this->renderer->render ( 'contact/index.html.twig' , [
          'contact' => $contact
        ] ) , 'text/html' );

      $this->mailer->send($message);



    }
  }