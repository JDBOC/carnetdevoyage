<?php

  namespace App\Controller;

  use App\Entity\Etapes;
  use App\Entity\Image;
  use App\Entity\Voyage;
  use App\Form\EtapesModifType;
  use App\Form\EtapesType;
  use App\Repository\EtapesRepository;
  use App\Repository\ImageRepository;
  use App\Repository\VoyageRepository;
  use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
  use Symfony\Component\HttpFoundation\Request;
  use Symfony\Component\HttpFoundation\Response;
  use Symfony\Component\Routing\Annotation\Route;

  /**
   * @Route("/etapes")
   */
  class EtapesController extends AbstractController
  {
    /**
     * @Route("/", name="etapes_index", methods={"GET"})
     */
    public function index(EtapesRepository $etapesRepository): Response
    {

      return $this->render ( 'etapes/index.html.twig' , [
        'etapes' => $etapesRepository->findAll ()
      ] );
    }

    /**
     * @Route("/new", name="etapes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
      $etape = new Etapes();

      $image = new Image();
      $image->setUrl ( 'http://placehold.it/400x200' )
        ->setCaption ( "caption a la con" );

      $etape->addImage ( $image );
      $form = $this->createForm ( EtapesType::class , $etape );
      $form->handleRequest ( $request );
      if ($form->isSubmitted () && $form->isValid ()) {
        $entityManager = $this->getDoctrine ()->getManager ();
        $etape->initializeSlug ();
        foreach ($etape->getImage () as $image) {
          $image->setEtapes ( $etape );
          $entityManager->persist ( $image );
        }
        $entityManager->persist ( $etape );
        $entityManager->flush ();
        $lieu = $etape->getVoyage ();
        $voyage = $lieu->getSlug ();
        return $this->redirectToRoute ( 'voyage_etapes' , [
          'slug' => $voyage
        ] );
      }

      return $this->render ( 'etapes/new.html.twig' , [
        'etape' => $etape ,
        'form' => $form->createView () ,
      ] );
    }


    /**
     * @Route("/{slug}", name="etapes_show", methods={"GET"})
     */
    public function show(VoyageRepository $repository , Etapes $etapes , ImageRepository $imageRepository): Response
    {
      $voyage = $repository->findOneBySlug ( $etapes );
      $image = $imageRepository->findByEtapes ( $etapes );
      return $this->render ( 'etapes/show.html.twig' , [
        'etape' => $etapes ,
        'voyage' => $voyage ,
        'images' => $image
      ] );
    }

    /**
     * @Route("/{slug}/edit", name="etapes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request , Etapes $etape): Response
    {
      $form = $this->createForm ( EtapesType::class , $etape );
      $form->handleRequest ( $request );

      if ($form->isSubmitted () && $form->isValid ()) {
        $this->getDoctrine ()->getManager ()->flush ();

        return $this->redirectToRoute ( 'etapes_show' , [
          'slug' => $etape->getSlug ()
        ] );
      }

      return $this->render ( 'etapes/edit.html.twig' , [

        'etape' => $etape ,
        'form' => $form->createView () ,
      ] );
    }

    /**
     * @Route("/{slug}", name="etapes_delete", methods={"DELETE"})
     */
    public function delete(Request $request , Etapes $etape): Response
    {
      if ($this->isCsrfTokenValid ( 'delete' . $etape->getId () , $request->request->get ( '_token' ) )) {
        $entityManager = $this->getDoctrine ()->getManager ();
        $entityManager->remove ( $etape );
        $entityManager->flush ();
      }

      return $this->redirectToRoute ( 'etapes_index' );
    }
  }
