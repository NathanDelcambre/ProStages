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
       // Récupérer les repository des entités Stage et Entreprise
       $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
       $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

       // Récupérer les ressources enregistrées en BD
       $ressourcesStagesParEntreprise = $repositoryStages->findBy(["Entreprise" => $id]);
       $ressourcesEntreprise = $repositoryEntreprise->find($id);
       $nbStages = count($ressourcesEntreprise->getEntreprises()); //Si nbStages = 0 alors la vue affichera qu'il n'y a pas de stages pour cette entreprise

       // Envoyer la ressource récupérée à la vue chargée de l'afficher
       return $this->render('entreprises/entreprises.html.twig', ['nbStages' => $nbStages, 'ressourcesStagesParEntreprise' => $ressourcesStagesParEntreprise, 'ressourcesEntreprise' => $ressourcesEntreprise]);
    }

    /**
     * @Route("/entreprises/", name="DescriptionEntreprises")
     */
    public function descriptionEntreprises(): Response
    {
       // Récupérer les repository des entités Entreprise
       $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);
       $ressourcesEntreprise = $repositoryEntreprise->findAll();

       // Envoyer la ressource récupérée à la vue chargée de l'afficher
       return $this->render('entreprises/descriptionEntreprises.html.twig', ['ressourcesEntreprise' => $ressourcesEntreprise]);
    }
}
