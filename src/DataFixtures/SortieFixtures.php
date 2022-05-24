<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Etat;
use App\Entity\Ville;
use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


class SortieFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $sortie1 = new Sortie();
        $sortie1->setNom('Piscine');
        $sortie1->setDateHeureDebut(new \DateTime('2022/7/7 12:00'));
        $sortie1->setDuree(100);
        $sortie1->setDateLimiteInscription(new \DateTime('2022/6/30 12:00'));
        $sortie1->setNbIscriptionsMax(50);
        $sortie1->setInfosSortie('Journee piscine avec competition');

        $manager->persist($sortie1);

        $sortie2 = new Sortie();
        $sortie2->setNom('Bowling');
        $sortie2->setDateHeureDebut(new \DateTime('2022/7/4 12:00'));
        $sortie2->setDuree(160);
        $sortie2->setDateLimiteInscription(new \DateTime('2022/7/1 12:00'));
        $sortie2->setNbIscriptionsMax(10);
        $sortie2->setInfosSortie('Competition de bowling');

        $manager->persist($sortie2);

        $sortie3 = new Sortie();
        $sortie3->setNom('Cinema');
        $sortie3->setDateHeureDebut(new \DateTime('2022/6/21 12:00'));
        $sortie3->setDuree(120);
        $sortie3->setDateLimiteInscription(new \DateTime('2022/6/20 12:00'));
        $sortie3->setNbIscriptionsMax(20);
        $sortie3->setInfosSortie('film d\'auteur bien chiant en vo');

        $manager->persist($sortie3);


        $sortie4 = new Sortie();
        $sortie4->setNom('Restaurant');
        $sortie4->setDateHeureDebut(new \DateTime('2022/7/5 12:00'));
        $sortie4->setDuree(190);
        $sortie4->setDateLimiteInscription(new \DateTime('2022/7/2 12:00'));
        $sortie4->setNbIscriptionsMax(10);
        $sortie4->setInfosSortie('Repas dans le noir complet....!');
        $manager->persist($sortie4);

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

        $lieu1=new Lieu();
        $lieu1->setNom('Piscine municipale');
        $lieu1->setRue('rue de la piscine');
        $manager->persist($lieu1);

        $lieu2=new Lieu();
        $lieu2->setNom('Bowling');
        $lieu2->setRue('rue des quilles');
        $manager->persist($lieu2);

        $lieu3=new Lieu();
        $lieu3->setNom('Musee de l\'art comtemporain');
        $lieu3->setRue('rue de l\'art');
        $manager->persist($lieu3);

        $lieu4=new Lieu();
        $lieu4->setNom('Restaurant');
        $lieu4->setRue('rue du resto');
        $manager->persist($lieu4);

        $lieu5=new Lieu();
        $lieu5->setNom('Bar');
        $lieu5->setRue('rue de la soif');
        $manager->persist($lieu5);

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


    $manager->flush();

    }
}

