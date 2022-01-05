<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formation;

class FormationsController extends AbstractController
{
    /**
     * @Route("/formations/{id}", name="Formations")
     */
    public function index($id): Response
    {
        // Récupérer le repository de l'entité Ressource
        $repositoryFormations = $this->getDoctrine()->getRepository(Formation::class);

        // Récupérer les ressources enregistrées en BD
        $ressourcesFormationParId = $repositoryFormations->find($id);

        // Envoyer la ressource récupérée à la vue chargée de l'afficher
        return $this->render('formations/formations.html.twig', ['ressourcesFormationParId' => $ressourcesFormationParId]);
    }
}
