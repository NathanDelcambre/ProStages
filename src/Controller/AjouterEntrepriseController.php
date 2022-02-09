<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;

class AjouterEntrepriseController extends AbstractController
{
    /**
    * @Route ("/ajouterEntreprise/" , name ="ajoutEntreprise")
    */
    public function ajouterEntreprise(Request $requeteHttp, ObjectManager $manager)
    {
        // Création d'une ressource initialement vierge
        $entreprise = new Entreprise();

        // création d'un objet formulaire pour ajouter une entreprise
        $formulaireEntreprise=$this->createFormBuilder($entreprise)
            -> add('activite', TextType::class)
            -> add('adresse', TextType::class)
            -> add('nom', TextType::class)
            -> add('url_site', UrlType::class)
            -> getForm();

            $formulaireEntreprise->handleRequest($requeteHttp);

            if ( $formulaireEntreprise->isSubmitted())
            {
                // Enregistrer la ressource en BD
                $manager->persist($entreprise);
                $manager->flush();
                // Rediriger l’utilisateur vers la page affichant la liste des ressources
                return $this->redirectToRoute('/');
            }

            return $this->render('ajouter_entreprise/ajouterEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise -> createView()]);
    }
}