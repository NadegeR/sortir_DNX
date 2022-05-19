<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker= Faker\Factory::create('fr_FR');
        for($u = 1; $u <=5; $u++) {
            $user = new User();
            $user->setNom($faker->name);
            $user->setPrenom($faker->lastName);
            $user->setEmail($faker->email);
            $user->setPassword($faker->password);
            $campus = $this->getReference('campus_' . $faker->numberBetween(1, 3));
            $user->setCampus($this->$campus);
            $user->setRoles(['ROLE_USER']);
            $user->setAcitif(true);
            $user->setAdministrateur(false);


            $manager->persist($user);
        }
            $manager->flush();
    }
}
