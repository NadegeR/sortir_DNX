<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {

        $user1 = new User();
        $user1->setNom('Rampon');
        $user1->setPrenom('Nadege');
        $user1->setEmail('nadege@exemple.com');
        $password = $this->passwordHasher->hashPassword($user1, 'qwerty');
        $user1->setPassword($password);
        $user1->setRoles(['ROLE_USER']);
        $user1->setAcitif(true);
        $user1->setAdministrateur(false);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setNom('Chevalier');
        $user2->setPrenom('Xavier');
        $user2->setEmail('xav@exemple.com');
        $password = $this->passwordHasher->hashPassword($user2, 'azerty');
        $user2->setPassword($password);
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setAcitif(true);
        $user2->setAdministrateur(true);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setNom('Urbain');
        $user3->setPrenom('David');
        $user3->setEmail('davidi@exemple.com');
        $password = $this->passwordHasher->hashPassword($user3, 'qwerty');
        $user3->setPassword($password);
        $user3->setRoles(['ROLE_ORG']);
        $user3->setAcitif(true);
        $user3->setAdministrateur(false);
        $manager->persist($user3);

        $user4 = new User();
        $user4->setNom('UserA');
        $user4->setPrenom('userA');
        $user4->setEmail('userA@exemple.com');
        $password = $this->passwordHasher->hashPassword($user4, 'qwerty');
        $user4->setPassword($password);
        $user4->setRoles(['ROLE_USER']);
        $user4->setAcitif(true);
        $user4->setAdministrateur(false);
        $manager->persist($user4);

        $campus1 = new Campus();
        $campus1->setNom("SAINT-HERBLAIN");
        $manager->persist($campus1);

        $campus2 = new Campus();
        $campus2->setNom("CHARTES DE BRETAGNE");
        $manager->persist($campus2);

        $campus3 = new Campus();
        $campus3->setNom("LA ROCHE SUR YON");
        $manager->persist($campus3);

        $manager->flush();
    }
}
