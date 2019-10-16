<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
