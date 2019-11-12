<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ImagesController extends AbstractController
{
    /**
     * @Route("/images/new", name="images")
     *
     */
    public function index(Request $request, ObjectManager $manager)
    {
      $image = new Images();
      $form = $this->createForm (ImagesType::class, $image);
      $form -> handleRequest ($request);

      if ($form -> isSubmitted () && $form -> isValid ()) {
        $file = $image->getUrl ();
        $fileName = md5 (uniqid ( '' , true )).'.'.$file->guessExtension();
        $file->move($this->getParameter ('images_directory'), $fileName);
        $image->setUrl ($fileName);

        $manager-> persist ($image);
        $manager->flush ();

        $this->redirectToRoute ('admin_dashboard');
      }

        return $this->render('images/new.html.twig', [
            'image' => $image,
            'form' => $form->createView (),

        ]);
    }
}
