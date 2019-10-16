<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CoordonatesController extends AbstractController
{
    /**
     * @Route("/coordonates", name="coordonates")
     */
    public function index()
    {
        return $this->render('coordonates/index.html.twig', [
            'controller_name' => 'CoordonatesController',
        ]);
    }
}
