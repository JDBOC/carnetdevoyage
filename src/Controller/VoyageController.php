<?php

namespace App\Controller;

use App\Repository\VoyageRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VoyageController extends AbstractController
{
    /**
     * @Route("/voyage", name="voyage_index")
     */
    public function index(VoyageRepository $voyageRepository)
    {
        return $this->render('voyage/index.html.twig', [
            'voyage' => $voyageRepository->findAll(),
        ]);
    }

    /**
     * Affichage d'une seule annonce
     * 
     * @Route("/voyage/{slug}", name="voyage_show")
     * 
     * @return Response
     */
    public function show($slug, VoyageRepository $voyageRepository) {
    
        $voyage = $voyageRepository->findOneBySlug($slug);

        return $this->render('voyage/show.html.twig', [
            'voyage' => $voyage
        ]);

    }





}
