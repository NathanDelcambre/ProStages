<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Stage;

class DonneesStage extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //$stage1 = new Stage();
        //$stage1->setCode("1");
        //$stage1->setTitre("Stage en algorithmie");
        //$stage1->setDescription("Chargé de résoudre une problème en algorithmie");
        //$stage1->setEmail("algo@orange.fr");
        
        
        //$manager->persist($stage1);
        //$manager->flush();
    }
}
