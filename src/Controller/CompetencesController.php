<?php

namespace App\Controller;

use App\Entity\Competences;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CompetencesController extends AbstractController
{
    /**
     * @Route("/competences", name="competences")
     */
    public function index()
    {
        return $this->render('competences/index.html.twig', [
            'controller_name' => 'CompetencesController',
        ]);
    }

  /**
   * @Route("/competences/new", name="newComp")
   */
    public function create()
    {
$competence = new Competences();
$form = $this->createFormBuilder ($competence)
              ->add ('titre')
              ->add ('picture')
              ->getForm ();

return $this->render ('competences/new.html.twig', [
  'form' => $form->createView ()
]);
    }
}
