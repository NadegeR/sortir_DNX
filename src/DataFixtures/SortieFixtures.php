<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Etat;
use App\Entity\User;
use App\Entity\Ville;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class SortieFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
//Etat
        $etat1=new Etat();
        $etat1->setLibelle('Créée');
        $manager->persist($etat1);

        $etat2=new Etat();
        $etat2->setLibelle('Ouverte');
        $manager->persist($etat2);

        $etat3=new Etat();
        $etat3->setLibelle('Clôturée');
        $manager->persist($etat3);

        $etat4=new Etat();
        $etat4->setLibelle('En cours');
        $manager->persist($etat4);

        $etat5=new Etat();
        $etat5->setLibelle('Passée');
        $manager->persist($etat5);

        $etat6=new Etat();
        $etat6->setLibelle('Annulée');
        $manager->persist($etat6);

// Villes
        $ville1= new Ville();
        $ville1->setNom('Quimper');
        $ville1->setCodePostal('29000');
        $manager->persist($ville1);

        $ville2= new Ville();
        $ville2->setNom('Brest');
        $ville2->setCodePostal('29200');
        $manager->persist($ville2);

        $ville3= new Ville();
        $ville3->setNom('Nantes');
        $ville3->setCodePostal('44000');
        $manager->persist($ville3);

        $ville4= new Ville();
        $ville4->setNom('Rennes');
        $ville4->setCodePostal('35000');
        $manager->persist($ville4);

//Lieu
        $lieu1=new Lieu();
        $lieu1->setNom('Piscine municipale');
        $lieu1->setRue('rue de la piscine');
        $lieu1->setVille($ville1);
        $manager->persist($lieu1);

        $lieu2=new Lieu();
        $lieu2->setNom('Bowling');
        $lieu2->setRue('rue des quilles');
        $lieu2->setVille($ville2);
        $manager->persist($lieu2);

        $lieu3=new Lieu();
        $lieu3->setNom('Musee de l\'art comtemporain');
        $lieu3->setRue('rue de l\'art');
        $lieu3->setVille($ville2);
        $manager->persist($lieu3);

        $lieu4=new Lieu();
        $lieu4->setNom('Restaurant aveugle');
        $lieu4->setRue('rue du resto');
        $lieu4->setVille($ville3);
        $manager->persist($lieu4);

        $lieu5=new Lieu();
        $lieu5->setNom('Bar tapas');
        $lieu5->setRue('rue de la soif');
        $lieu5->setVille($ville4);
        $manager->persist($lieu5);

        $lieu6=new Lieu();
        $lieu6->setNom('Musée');
        $lieu6->setRue('rue du musée');
        $lieu6->setVille($ville4);
        $manager->persist($lieu6);

        $lieu7=new Lieu();
        $lieu7->setNom('Cinema');
        $lieu7->setRue('rue des lumières');
        $lieu7->setVille($ville4);
        $manager->persist($lieu7);

//Campus
        $campus1 = new Campus();
        $campus1->setNom("SAINT-HERBLAIN");
        $manager->persist($campus1);

        $campus2 = new Campus();
        $campus2->setNom("CHARTES DE BRETAGNE");
        $manager->persist($campus2);

        $campus3 = new Campus();
        $campus3->setNom("LA ROCHE SUR YON");
        $manager->persist($campus3);

//User
        $user1 = new User();
        $user1->setPseudo('Nana');
        $user1->setNom('Rampon');
        $user1->setPrenom('Nadege');
        $user1->setEmail('nadege@exemple.com');
        $user1->setTelephone('0102030405');
        $password = $this->passwordHasher->hashPassword($user1, 'qwerty');
        $user1->setPassword($password);
        $user1->setRoles(['ROLE_USER']);
        $user1->setActif(true);
        $user1->setAdministrateur(false);
        $user1->setCampus($campus1);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setPseudo('Xav');
        $user2->setNom('Chevalier');
        $user2->setPrenom('Xavier');
        $user2->setEmail('xav@exemple.com');
        $password = $this->passwordHasher->hashPassword($user2, 'azerty');
        $user2->setPassword($password);
        $user2->setRoles(['ROLE_ADMIN']);
        $user2->setActif(true);
        $user2->setAdministrateur(true);
        $user2->setCampus($campus2);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setNom('Urbain');
        $user3->setPrenom('David');
        $user3->setEmail('davidi@exemple.com');
        $password = $this->passwordHasher->hashPassword($user3, 'qwerty');
        $user3->setPassword($password);
        $user3->setRoles(['ROLE_ORG']);
        $user3->setActif(true);
        $user3->setAdministrateur(false);
        $user3->setCampus($campus2);
        $manager->persist($user3);

        $user4 = new User();
        $user4->setNom('UserA');
        $user4->setPrenom('userA');
        $user4->setEmail('userA@exemple.com');
        $password = $this->passwordHasher->hashPassword($user4, 'qwerty');
        $user4->setPassword($password);
        $user4->setRoles(['ROLE_USER']);
        $user4->setActif(true);
        $user4->setAdministrateur(false);
        $user4->setCampus($campus3);
        $manager->persist($user4);

//Sortie
        $sortie1 = new Sortie();
        $sortie1->setNom('Piscine');
        $sortie1->setDateHeureDebut(new \DateTime('2022/7/7 12:00'));
        $sortie1->setDuree(120);
        $sortie1->setDateLimiteInscription(new \DateTime('2022/6/30 12:00'));
        $sortie1->setNbIscriptionsMax(50);
        $sortie1->setInfosSortie('Journee piscine avec competition');
        $sortie1->setSiteOrganisateur($campus1);
        $sortie1->setOrganisateurs($user1);
        $sortie1->setLieu($lieu1);
        $sortie1->setEtat($etat1);
        $manager->persist($sortie1);

        $sortie2 = new Sortie();
        $sortie2->setNom('Bowling');
        $sortie2->setDateHeureDebut(new \DateTime('2022/7/4 12:00'));
        $sortie2->setDuree(160);
        $sortie2->setDateLimiteInscription(new \DateTime('2022/7/1 12:00'));
        $sortie2->setNbIscriptionsMax(10);
        $sortie2->setInfosSortie('Competition de bowling');
        $sortie2->setSiteOrganisateur($campus2);
        $sortie2->setOrganisateurs($user2);
        $sortie2->setLieu($lieu2);
        $sortie2->setEtat($etat2);
        $manager->persist($sortie2);

        $sortie3 = new Sortie();
        $sortie3->setNom('Cinema');
        $sortie3->setDateHeureDebut(new \DateTime('2022/6/21 12:00'));
        $sortie3->setDuree(120);
        $sortie3->setDateLimiteInscription(new \DateTime('2022/6/20 12:00'));
        $sortie3->setNbIscriptionsMax(20);
        $sortie3->setInfosSortie('film d\'auteur bien chiant en vo');
        $sortie3->setSiteOrganisateur($campus2);
        $sortie3->setOrganisateurs($user3);
        $sortie3->setLieu($lieu3);
        $sortie3->setEtat($etat2);
        $manager->persist($sortie3);


        $sortie4 = new Sortie();
        $sortie4->setNom('Restaurant');
        $sortie4->setDateHeureDebut(new \DateTime('2022/6/15 12:00'));
        $sortie4->setDuree(190);
        $sortie4->setDateLimiteInscription(new \DateTime('2022/6/10 12:00'));
        $sortie4->setNbIscriptionsMax(10);
        $sortie4->setInfosSortie('Repas dans le noir complet....!');
        $sortie4->setSiteOrganisateur($campus3);
        $sortie4->setOrganisateurs($user4);
        $sortie4->setLieu($lieu4);
        $sortie4->setEtat($etat2);
        $manager->persist($sortie4);

        $sortie5 = new Sortie();
        $sortie5->setNom('Tapas');
        $sortie5->setDateHeureDebut(new \DateTime('2022/7/10 12:00'));
        $sortie5->setDuree(190);
        $sortie5->setDateLimiteInscription(new \DateTime('2022/7/2 12:00'));
        $sortie5->setNbIscriptionsMax(10);
        $sortie5->setInfosSortie('Soiree conviviale autour de taps et d\'un verre');
        $sortie5->setSiteOrganisateur($campus1);
        $sortie5->setOrganisateurs($user1);
        $sortie5->setLieu($lieu5);
        $sortie5->setEtat($etat2);
        $manager->persist($sortie5);

        $sortie6 = new Sortie();
        $sortie6->setNom('Cinema');
        $sortie6->setDateHeureDebut(new \DateTime('2022/6/20 14:00'));
        $sortie6->setDuree(120);
        $sortie6->setDateLimiteInscription(new \DateTime('2022/6/18 12:00'));
        $sortie6->setNbIscriptionsMax(20);
        $sortie6->setInfosSortie('Le dernier Disney');
        $sortie6->setSiteOrganisateur($campus1);
        $sortie6->setOrganisateurs($user1);
        $sortie6->setLieu($lieu7);
        $sortie6->setEtat($etat2);
        $manager->persist($sortie6);

        $sortie7 = new Sortie();
        $sortie7->setNom('Musée');
        $sortie7->setDateHeureDebut(new \DateTime('2022/7/5 12:00'));
        $sortie7->setDuree(190);
        $sortie7->setDateLimiteInscription(new \DateTime('2022/7/2 12:00'));
        $sortie7->setNbIscriptionsMax(10);
        $sortie7->setInfosSortie('Repas dans le noir complet....!');
        $sortie7->setSiteOrganisateur($campus3);
        $sortie7->setOrganisateurs($user4);
        $sortie7->setLieu($lieu6);
        $sortie7->setEtat($etat2);
        $manager->persist($sortie7);


    $manager->flush();

    }
}

