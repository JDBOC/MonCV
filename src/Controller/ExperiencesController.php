<?php

namespace App\Controller;

use App\Entity\Experiences;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Annotation\Route;


class ExperiencesController extends AbstractController
{
    /**
     * @Route("/experiences", name="experiences")
     */
    public function index()
    {
        return $this->render('experiences/index.html.twig', [
            'controller_name' => 'ExperiencesController',
        ]);
    }

  /**
   * @route("/experiences/new", name="newExp")
   */
    public function new()
    {
      $experience = new Experiences();

      $form = $this -> createFormBuilder ($experience)
                    ->add ('company')
                    ->add ('title')
                    ->add ('entree', DateType::class)
                    ->add ('sortie', DateType::class)
                    ->add ('descriptif', CKEditor::class)
                    ->add ('lieu')
                    ->getForm ();

      return $this->render ('experiences/new.html.twig', [
        'form' => $form->createView ()
      ]);



    }

}
