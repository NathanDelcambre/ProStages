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
        $faker = \Faker\Factory::create('fr_FR');

        $lesNomsEntreprises = array("Microsoft", "Apple", "Orange", "SuperDry","Subway", "CocaCola", "SFR", "AirBus","BlackBerry","NavalGroup");
        $lesNomsFormations = array("DUT Informatique", "DUT Génie Civil", "LP Programmation", "Master Aéronautique","Master Biologie", "Master Chimie", "DUT Tech de Co", "DUT Génie Électrique","Centrale Nantes","Mines Nantes");
        $lesDiminutifsFormations = array("DUT Info", "DUT GC", "LP Prog", "Mast Aéro","Mast Bio", "Mast Chi", "DUT TC", "DUT GE","Cent Nan","Min Nan");
        $lesActivites = array("Programmation", "Algorithmie", "Conception", "Développement","Création graphique", "Électronique", "Biochimie", "Aéronautique","Arithmétiques","Aéronavale");
        $lesEntreprises=array();
        $lesFormations=array();

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

        for($i=0; $i < count($lesNomsFormations); $i=$i+1)
        {
            $formation = new Formation();
            $formation->setNomLong($lesNomsFormations[$i]);
            $formation->setNomCourt($lesDiminutifsFormations[$i]);
            $lesFormations[$i]=$formation;    //Ajout des formations dans le tableau
            $manager->persist($formation);
        }

        $nbStages = 30;

        for($i=1; $i <= $nbStages; $i=$i+1)
        {
            $stage = new Stage();
            $stage->setTitre($faker->realText($maxNbChars = 60, $indexSize = 2));
            $stage->setDescription($faker->realText($maxNbChars = 250, $indexSize = 2));
            $stage->setEmail($faker->safeEmail());
            $stage->setEntreprise($lesEntreprises[rand(0,9)]);
            $stage->addFormation($lesFormations[rand(0,9)]);
            $manager->persist($stage);
        }
        $manager->flush();
    }
}