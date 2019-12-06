<?php

namespace App\Controller;

use App\Entity\Voyage;
use App\Entity\Image;
use App\Entity\Etapes;
use App\Form\VoyageType;
use App\Form\ImageType;
use App\Repository\EtapesRepository;
use App\Repository\VoyageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/voyage")
 */
class VoyageController extends AbstractController
{
  /**
   * @Route("/", name="voyage_index", methods={"GET"})
   * @param VoyageRepository $voyageRepository
   * @return Response
   */
    public function index(VoyageRepository $voyageRepository): Response
    {
        return $this->render('voyage/index.html.twig', [
            'voyages' => $voyageRepository->findAll(),
        ]);
    }

  /**
   * @Route("/new", name="voyage_new", methods={"GET","POST"})
   * @param Request $request
   * @return Response
   */
    public function new(Request $request): Response
    {
        $voyage = new Voyage();

        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();

            foreach ($voyage->getImages () as $image){
              $image->setVoyage ($voyage);
              $entityManager->persist ($image);
            }
            $entityManager->persist($voyage);
            $entityManager->flush();
            return $this->redirectToRoute('voyage_index');
        }
        return $this->render('voyage/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

  /**
   * @Route("/{slug}", name="voyage_show", methods={"GET"})
   * @param Voyage $voyage
   * @return Response
   */
    public function show(Voyage $voyage): Response
    {
        return $this->render('voyage/show.html.twig', [
            'voyage' => $voyage,
        ]);
    }

  /**
   * @Route("/{slug}/etapes", name="voyage_etapes")
   *
   */
    public function showEtapes(Voyage $voyage, EtapesRepository $etapesRepository){
      $etapes = $etapesRepository->findByVoyage ($voyage);

      return $this->render ('etapes/index.html.twig', [
        'voyage' => $voyage,
        'etapes' => $etapes,

      ]);
    }



  /**
   * @Route("/{slug}/edit", name="voyage_edit", methods={"GET","POST"})
   * @param Request $request
   * @param Voyage $voyage
   * @return Response
   */
    public function edit(Request $request, Voyage $voyage): Response
    {
        $form = $this->createForm(VoyageType::class, $voyage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('voyage_index');
        }

        return $this->render('voyage/edit.html.twig', [
            'voyage' => $voyage,
            'form' => $form->createView(),
        ]);
    }

  /**
   * @Route("/{slug}", name="voyage_delete", methods={"DELETE"})
   * @param Request $request
   * @param Voyage $voyage
   * @return Response
   */
    public function delete(Request $request, Voyage $voyage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voyage->getSlug(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($voyage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('voyage_index');
    }
}
