<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Stage;

class DonneesStage extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');
        
        for($i=1; $i <= $nbEntreprises; $i=$i+1)
        {
            $stage = new Stage();
            $stage->setCode("1");
            $stage->setTitre("Stage en algorithmie");
            $stage->setDescription("Chargé de résoudre une problème en algorithmie");
            $stage->setEmail("algo@orange.fr");
            $manager->persist($stage);
        }
        //$manager->flush();
    }
}
