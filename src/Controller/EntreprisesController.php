<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use App\Entity\Stage;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class EntreprisesController extends AbstractController
{
    /**
     * @Route("/entreprises/{nom}", name="Entreprises")
     */
    public function index($nom): Response
    {
       // Récupérer les repository des entités Stage et Entreprise
       $repositoryStages = $this->getDoctrine()->getRepository(Stage::class);
       $repositoryEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

       // Récupérer les ressources enregistrées en BD
       $ressourcesStagesParEntreprise = $repositoryStages->trouverStagesEntreprise($nom);
       $nomEntreprise = $nom;
       // Envoyer la ressource récupérée à la vue chargée de l'afficher
       return $this->render('entreprises/entreprises.html.twig', ['ressourcesStagesParEntreprise' => $ressourcesStagesParEntreprise , 'nomEntreprise' => $nomEntreprise]);
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

    /**
     * @Route("/ajouterEntreprise", name="AjoutEntreprise")
     */
    public function ajoutEntreprise(Request $requeteHttp, EntityManagerInterface $manager): Response
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

            if($formulaireEntreprise->isSubmitted())
            {
                // Enregistrer la ressource en BD
                $manager->persist($entreprise);
                $manager->flush();
                // Rediriger l’utilisateur vers la page affichant la liste des ressources
                return $this->redirectToRoute('Accueil');
            }

            return $this->render('entreprises/ajouterEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise -> createView()]);
    }

}
