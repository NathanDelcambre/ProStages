<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use App\Entity\Stage;

class EntreprisesController extends AbstractController
{
    /**
     * @Route("/entreprises/{id}", name="Entreprises")
     */
    public function index($id): Response
    {
       // Récupérer le repository de l'entité Ressource
       $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
       $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

       // Récupérer les ressources enregistrées en BD
       $ressourcesStagesParEntreprise = $repositoryStages->findByEntrepriseId($id);
       $ressourcesEntreprise = $repositoryEntreprise->find($id);

       // Envoyer la ressource récupérée à la vue chargée de l'afficher
       return $this->render('entreprises/entreprises.html.twig', ['ressourcesStagesParEntreprise' => $ressourcesStagesParEntreprise, 'ressourcesEntreprise' => $ressourcesEntreprise]);
    }
}
