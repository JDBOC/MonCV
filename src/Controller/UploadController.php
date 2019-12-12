<?php

  namespace App\Controller;

  use App\Entity\Upload;
  use App\Form\UploadType;
  use App\Repository\UploadRepository;
  use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\File\Exception\FileException;
  use Symfony\Component\HttpFoundation\File\UploadedFile;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;

  /**
   * @Route("/upload")
   */
  class UploadController extends AbstractController
  {
    /**
     * @Route("/", name="upload_index", methods={"GET"})
     */
    public function index(UploadRepository $uploadRepository): Response
    {
      return $this->render ( 'upload/index.html.twig' , [
        'upload' => $uploadRepository->findAll () ,
      ] );
    }

    /**
     * @Route("/new", name="upload_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Request $request): Response
    {
      $upload = new Upload();
      $form = $this->createForm ( UploadType::class , $upload );
      $form->handleRequest ( $request );
      if ($form->isSubmitted () && $form->isValid ()) {
        $file = $upload->getTitre ();
        $fileName = md5 (uniqid ()).'.'.$file->guessExtension();
        $file->move($this->getParameter ('upload_directory'), $fileName);
        $upload->setUrl (realpath ('/public/images/'.'/'.$fileName));
        $upload->setTitre ($fileName);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($upload);
        $entityManager->flush();



        return $this->redirectToRoute ( 'upload_index' );
      }

      return $this->render ( 'upload/new.html.twig' , [
        'form' => $form->createView () ,
      ] );

    }

    /**
     * @Route("/{id}", name="upload_show", methods={"GET"})
     */
    public function show(Upload $upload): Response
    {
      return $this->render ( 'upload/show.html.twig' , [
        'upload' => $upload ,
      ] );
    }

    /**
     * @Route("/{id}/edit", name="upload_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function edit(Request $request , Upload $upload): Response
    {
      $form = $this->createForm ( UploadType::class );
      $form->handleRequest ( $request );

      if ($form->isSubmitted () && $form->isValid ()) {
        $this->getDoctrine ()->getManager ()->flush ();

        return $this->redirectToRoute ( 'upload_index' );
      }

      return $this->render ( 'upload/edit.html.twig' , [
        'upload' => $upload ,
        'form' => $form->createView () ,
      ] );
    }

    /**
     * @Route("/{id}", name="upload_delete", methods={"DELETE"})
     * @IsGranted("ROLE_USER")
     */
    public function delete(Request $request , Upload $upload): Response
    {
      if ($this->isCsrfTokenValid ( 'delete' . $upload->getId () , $request->request->get ( '_token' ) )) {
        $entityManager = $this->getDoctrine ()->getManager ();
        $entityManager->remove ( $upload );
        $entityManager->flush ();
      }

      return $this->redirectToRoute ( 'upload_index' );
    }
  }
