<?php

namespace App\Controller;

use App\Entity\Images;
use App\Entity\Portfolio;
use App\Form\ImagesType;
use App\Repository\ImagesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImagesController extends AbstractController
{

  /**
   * @Route("/pictures", name="pictures_index")
   * @param ImagesRepository $repository
   * @return Response
   */
  public function index(ImagesRepository $repository) {

    return $this->render('images/index.html.twig', [
      'pictures' => $repository ->findAll(),
  ]);
  }

  /**
   * @Route("/pictures/new", name="pictures")
   * @IsGranted("ROLE_USER")
   * @param Request $request
   * @param Portfolio $portfolio
   * @return Response
   */
    public function new(Request $request)
    {
      $image = new Images();
      $form = $this->createForm (ImagesType::class, $image);
      $form -> handleRequest ($request);

      if ($form -> isSubmitted () && $form -> isValid ()) {
      $file = $image->getUrl ();
      $fileName = str_replace (" ", "", $image->getTitre ()).'.'.$file->guessExtension();
        try {
          $file->move(
            $this->getParameter('images_directory'),
            $fileName
          );
        } catch (FileException $e) {
          // ... handle exception if something happens during file upload
        }

        $manager = $this->getDoctrine()->getManager();
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
