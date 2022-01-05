<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Formation;

class DonneesFormation extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i=1; $i <= $nbEntreprises; $i=$i+1)
        {
            $formation1 = new Product();
            $formation1->setNomLong();
            $formation1->setNomCourt();
            $manager->persist($formation1);
        }

        $manager->flush();
    }
}
