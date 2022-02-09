<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;

class AjouterEntrepriseController extends AbstractController
{
    /**
    * @Route ("/ajouterEntreprise/" , name ="ajoutEntreprise")
    */
    public function ajouterEntreprise()
    {
        // Création d'une ressource initialement vierge
        $entreprise = new Entreprise();

        // création d'un objet formulaire pour ajouter une entreprise
        $formulaireEntreprise=$this->createFormBuilder($entreprise)
            -> add('activite')
            -> add('adresse')
            -> add('nom')
            -> add('url_site')
            -> getForm();

            return $this->render('ajouter_entreprise/ajouterEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise -> createView()]);
    }
}