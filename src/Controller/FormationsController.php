<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formation;
use App\Entity\Stage;

class FormationsController extends AbstractController
{
    /**
     * @Route("/formations/{id}", name="Formations")
     */
    public function index($id): Response
    {
        // Récupérer le repository de l'entité Ressource
        $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
        $repositoryFormations = $this->getDoctrine()->getRepository(Formation::class);

        // Récupérer les ressources enregistrées en BD

        $ressourcesStagesParFormation = $repositoryStages->findAll();
        $ressourcesFormation = $repositoryFormations->find($id);

        $lesStages = $ressourcesFormation->getFormations();

        // Envoyer la ressource récupérée à la vue chargée de l'afficher
        return $this->render('formations/formations.html.twig', ['ressourcesStagesParFormation' => $ressourcesStagesParFormation, 'ressourcesFormation' => $ressourcesFormation, 'lesStages' => $lesStages]);
    }
}
