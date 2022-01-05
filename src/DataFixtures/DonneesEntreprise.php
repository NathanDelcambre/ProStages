<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Entreprise;

class DonneesEntreprise extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        $nbEntreprises = 10;

        for($i=1; $i <= $nbEntreprises; $i=$i+1)
        {
            $entreprise1 = new Product();
            $entreprise->setActivite();
            $entreprise->setAdresse();
            $entreprise->setNom();
            $entreprise->setUrlSite();
            $entreprise1->persist($entreprise);
        }
        
        $manager->flush();
    }
}
