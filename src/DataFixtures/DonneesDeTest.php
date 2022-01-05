<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Entity\Stage;

class DonneesEntreprise extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create('fr_FR');

        $lesNomsEntreprises = array("Microsoft", "Apple", "Orange", "SuperDry","Subway", "CocaCola", "SFR", "AirBus","BlackBerry","NavalGroup");
        $lesFormations = array("DUT Informatique", "DUT Génie Civil", "LP Programmation", "Master Aéronautique","Master Biologie", "Master Chimie", "DUT Tech de Co", "DUT Génie Électrique","Centrale Nantes","Mines Nantes");
        $lesEntreprises=array();

        for($i=0; $i < count($lesEntreprises); $i=$i+1)
        {
            $entreprise = new Entreprise();
            $entreprise->setActivite($faker->safeEmail());
            $entreprise->setAdresse($faker->streetAddress());
            $entreprise->setNom($lesNomsEntreprises[$i]);
            $entreprise->setUrlSite($faker->domainName());
            $lesEntreprises[$i]=$entreprise;
            $manager->persist($entreprise);
        }

        for($i=0; $i < count($lesFormations); $i=$i+1)
        {
            $formation = new Formation();
            $formation->setNomLong($lesFormations[$i]);
            $formation->setNomCourt($faker->regexify('[A-Za-z]{4}'));
            $manager->persist($formation);
        }

        $nbStages = 30;

        for($i=1; $i <= $nbStages; $i=$i+1)
        {
            $stage = new Stage();
            $stage->setTitre($faker->sentence());
            $stage->setDescription($faker->text(200));
            $stage->setEmail($faker->safeEmail());
            $stage->setEntreprise($faker->randomDigit());
            $stage->setFormation($faker->randomDigit());

            $manager->persist($stage);
        }
        $manager->flush();
    }
}
