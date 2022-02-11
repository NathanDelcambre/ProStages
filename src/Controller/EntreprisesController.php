<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Entreprise;
use App\Entity\Stage;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

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
     * @Route("/ajouter_entreprise", name="AjoutEntreprise")
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
            -> add('urlSite', UrlType::class)
            -> getForm();

            $formulaireEntreprise->handleRequest($requeteHttp);

            if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
            {
                // Enregistrer la ressource en BD
                $manager->persist($entreprise);
                $manager->flush();
                // Rediriger l’utilisateur vers la page affichant la liste des ressources
                return $this->redirectToRoute('Accueil');
            }

            return $this->render('entreprises/ajouterModifierEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise -> createView(),'action' => "ajouter"]);
    }

     /**
     * @Route("/modifier_entreprise/{id}", name="ModifierEntreprise")
     */
    public function modifierEntreprise(Request $requeteHttp, EntityManagerInterface $manager, Entreprise $uneEntreprise): Response
    {
        // création d'un objet formulaire pour ajouter une entreprise
        $formulaireEntreprise=$this->createFormBuilder($uneEntreprise)
            -> add('activite', ChoiceType::class,
            array(
                    'choices' => array(
                        'Administration' => 'Administration',
                        'Aéronautique' => 'Aéronautique',
                        'Aéronavale' => 'Aéronavale',
                        'Agroalimentaire' => 'Agroalimentaire',
                        'Algorithmie' => 'Algorithmie',
                        'Arithmétiques' => 'Arithmétiques',
                        'Arts' => 'Arts',
                        'Assurance' => 'Assurance',
                        'Automobile' => 'Automobile',
                        'Biochimie' => 'Biochimie',
                        'Bois' => 'Bois',
                        'Chaussures' => 'Chaussures',
                        'Chaussures' => 'Chaussures',
                        'Chimie' => 'Chimie',
                        'Communication' => 'Communication',
                        'Conception' => 'Conception',
                        'Création graphique' => 'Création graphique',
                        'Développement' => 'Développement',
                        'Distribution' => 'Distribution',
                        'Droit' => 'Droit',
                        'Édition' => 'Édition',
                        'Électronique' => 'Électronique',
                        'Électricité' => 'Électricité',
                        'Énergie' => 'Énergie',
                        'Études' => 'Communication',
                        'Fonction publique' => 'Fonction publique',
                        'Immobilier' => 'Immobilier',
                        'Imprimerie' => 'Imprimerie',
                        'Industrie pharmaceutique' => 'Industrie pharmaceutique',
                        'Logistique' => 'Logistique',
                        'Machines et équipements' => 'Machines et équipements',
                        'Métallurgie' => 'Métallurgie',
                        'Multimédia' => 'Multimédia',
                        'Industrie pharmaceutique' => 'Industrie pharmaceutique',
                        'Industrie pharmaceutique' => 'Industrie pharmaceutique',
                        'Plastique' => 'Plastique',
                        'Programmation' => 'Programmation',
                        'Restauration' => 'Restauration',
                        'Santé' => 'Santé',
                        'Services aux entreprises' => 'Services aux entreprises',
                        'Sports' => 'Sports',
                        'Télécoms' => 'Télécoms',
                        'Textile' => 'Textile',
                        'Toursime' => 'Toursime',
                        'Transports' => 'Transports',
                        'Université' => 'Université',
                )))
            -> add('adresse', TextType::class)
            -> add('nom', TextType::class)
            -> add('urlSite', UrlType::class)
            -> getForm();

            $formulaireEntreprise->handleRequest($requeteHttp);

            if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
            {
                // Enregistrer la ressource en BD
                $manager->persist($uneEntreprise);
                $manager->flush();
                // Rediriger l’utilisateur vers la page affichant la liste des ressources
                return $this->redirectToRoute('Accueil');
            }

            return $this->render('entreprises/ajouterModifierEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise -> createView(),'action' => "modifier",'entreprise' => $uneEntreprise]);
    }

}
