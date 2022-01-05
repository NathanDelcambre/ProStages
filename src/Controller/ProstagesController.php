<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProstagesController extends AbstractController
{
    /**
     * @Route("/", name="Accueil")
     */
    public function index(): Response
    {
        $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
        $ressourcesStages = $repositoryStages->findAll();

        $repositoryFormations = $this->getDoctrine()->getRepository(Formation::class);
        $ressourcesFormations = $repositoryFormations->findAll();

        $repositoryEntreprises = $this->getDoctrine()->getRepository(Entreprise::class);
        $ressourcesEntreprises = $repositoryEntreprises->findAll();

        return $this->render('Prostages/prostages.html.twig', [
            'controller_name' => 'to accueil',
            'ressourcesStages' => $ressourcesStages,
            'ressourcesFormations' => $ressourcesFormations,
            'ressourcesEntreprises' => $ressourcesEntreprises,
        ]);
    }
}