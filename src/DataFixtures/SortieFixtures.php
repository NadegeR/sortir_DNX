<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Sortie;
Use App\Entity\Etat;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use Container9OHpzSP\getCampusRepositoryService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class SortieFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
//        $faker= Faker\Factory::create('fr_FR');
//        for($s = 1; $s <=8; $s++) {
//            $sortie1 = new Sortie();
//            $sortie1->setNom($faker->name);
//            $sortie1->setDateHeureDebut($faker->dateTime);
//            $sortie1->setDuree($faker->numberBetween(30, 500));
//            $etat = $this->getReference('etat.cree');
//            $sortie1->setEtat($this->$etat);
//            $campus= $this->getReference('campus_' . $faker->numberBetween(1, 3));
//            $sortie1->setSiteOrganisateur($this->$campus);
//            $lieux = $faker->randomElements(['cinema', 'bowling', 'piscine', 'poterie'], 1, true);
//            $sortie1->setLieu($this->$lieux);
//            $sortie1->setNbIscriptionsMax($faker->numberBetween(5, 100));
//            $sortie1->setOrganisateur($faker->numberBetween(1, 5));
//
//
//            $manager->persist($sortie1);
//        }
//        $manager->flush();
    }
}
