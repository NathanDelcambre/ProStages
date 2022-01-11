<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class Donnees extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Module pour générer des données aléatoires
        $faker = \Faker\Factory::create('fr_FR');

        //Tableaux de données pour avoir certaines données cohérentes
        $lesNomsEntreprises = array("Microsoft", "Apple", "Orange", "SuperDry","Subway", "CocaCola", "SFR", "AirBus","BlackBerry","NavalGroup");
        $lesNomsFormations = array("DUT Informatique", "DUT Génie Civil", "LP Programmation", "Master Aéronautique","Master Instrumentation", "Master Système", "DUT Tech de Co", "DUT Génie Électrique","Centrale Nantes","Mines Nantes");
        $lesDiminutifsFormations = array("DUT Info", "DUT GC", "LP Prog", "Mast Aéro","Mast Ins", "Mast Sys", "DUT TC", "DUT GE","Cent Nan","Min Nan");
        $lesActivites = array("Programmation", "Algorithmie", "Conception", "Développement","Création graphique", "Électronique", "Biochimie", "Aéronautique","Arithmétiques","Aéronavale");
        
        //Données pour la future génération aléatoire d'un titre de stage
        $titre1 = array("Programmation", "Réalisation", "Conception", "Développement","Structuration", "Imagination", "Enrichissement", "Amélioration","Modification","Supervision");
        $titre2 = array(" d'un site web", " d'une application web", " d'un programme", " d'une application"," d'un réseau", " d'une base de données", " d'un système", " d'une interface"," d'un jeu"," d'une architecture");
        $titre3 = array(" en Java.", " en Python.", " en C++.", " en CSS."," en Arduino.", " en C#.", " en série.", " de puissance."," de calcul."," de fusion informatique.");
        
        //Tableaux de recueil des données formations et entreprises
        $lesEntreprises=array();
        $lesFormations=array();

        //-------------------Génération des données de la table 'entreprise'-------------------//
        for($i=0; $i < count($lesNomsEntreprises); $i=$i+1)
        {
            $entreprise = new Entreprise();
            $entreprise->setActivite($lesActivites[rand(0,9)]);
            $entreprise->setAdresse($faker->streetAddress());
            $entreprise->setNom($lesNomsEntreprises[$i]);
            $entreprise->setUrlSite($faker->domainName());
            $lesEntreprises[$i]=$entreprise;    //Ajout des entreprises dans le tableau
            $manager->persist($entreprise);
        }

        //-------------------Génération des données de la table 'formation'-------------------//
        for($i=0; $i < count($lesNomsFormations); $i=$i+1)
        {
            $formation = new Formation();
            $formation->setNomLong($lesNomsFormations[$i]);
            $formation->setNomCourt($lesDiminutifsFormations[$i]);
            $lesFormations[$i]=$formation;    //Ajout des formations dans le tableau
            $manager->persist($formation);
        }

        //-------------------Génération des données de la table 'stage'-------------------//
        $nbStages = 30;

        for($i=1; $i <= $nbStages; $i=$i+1)
        {
            $stage = new Stage();
            $stage->setTitre($titre1[rand(0,9)].$titre2[rand(0,9)].$titre3[rand(0,9)]);
            $stage->setDescription($faker->realText($maxNbChars = 250, $indexSize = 2));
            $stage->setEmail($faker->safeEmail());
            $stage->setEntreprise($lesEntreprises[rand(0,8)]); //La 10ème entreprise sert de témoin pour une entreprise n'ayant aucun stage

            // On génère 1 ou 2 formations DIFFÉRENTES (possibilité d'utiliser UNIQUE de Faker, ceci est une autre méthode pour y parvenir)
            $nbFormations = rand(1,2); //Décide si le stage aura 1 ou 2 formations concernées
            $numFormation = $faker->numberBetween(0,9);

            if($nbFormations == 1){
                $stage->addFormation($lesFormations[$numFormation]);   
            }
            else{
                $stage->addFormation($lesFormations[$numFormation]);  // Ajout de la première formation
                $lesFormations2 = $lesFormations;  // Copie du tableau initial
                unset($lesFormations2[$numFormation]);  // Suppression de la formation déjà utilisée
                $lesFormations2 = array_merge($lesFormations2);  // Mise à jour de l'indexation du tableau
                $stage->addFormation($lesFormations[rand(0,8)]);  // Ajout de la seconde formation au hasard dans les formations restantes
            }

            $manager->persist($stage);
        }
        $manager->flush();
    }
}