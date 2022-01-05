<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;

class EntreprisesController extends AbstractController
{
    /**
     * @Route("/entreprises/{id}", name="Entreprises")
     */
    public function index($id): Response
    {
        $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);
        $ressources = $repositoryEntreprise->findAll();

        return $this->render('entreprises/entreprises.html.twig', [
            'controller_name' => 'EntreprisesController',
            'id' => $id,
            'ressources' => $ressources,
        ]);
    }
}
