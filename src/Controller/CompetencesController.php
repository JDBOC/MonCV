<?php

namespace App\Controller;

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
}
