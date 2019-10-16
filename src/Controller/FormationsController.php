<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FormationsController extends AbstractController
{
    /**
     * @Route("/f/formations", name="f_formations")
     */
    public function index()
    {
        return $this->render('f_formations/index.html.twig', [
            'controller_name' => 'FormationsController',
        ]);
    }
}
