<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sortie>
 *
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    public function add(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sortie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function sortieParFiltres($filtre): array
    {
        $queryB = $this->createQueryBuilder('sortie');

        if ($filtre['campus']) {
            $queryB->andWhere('sortie.siteOrganisateur = :campus')
                ->setParameter('campus', $filtre['campus']);
        }

        if ($filtre['nom']) {
            $queryB->andWhere('sortie.nom LIKE :nom')
                ->setParameter('nom', '%' . $filtre['nom'] . '%');
        }

        if ($filtre['dateDebut'] || $filtre['dateFin']) {
            $dateDebut = $filtre['dateDebut'] ? date_format($filtre['dateDebut'], 'Y-m-d') : date('Y-m-d');
            $dateFin = $filtre['dateFin'] ? date_format($filtre['dateFin'], 'Y-m-d') : date('Y-m-d');
            $queryB->andWhere('sortie.dateHeureDebut = :dateFin OR sortie.dateHeureDebut BETWEEN :dateDebut and :dateFin')
//                ->andWhere('sortie.dateHeureDebut = :dateDebut')
                ->setParameter('dateDebut', $dateDebut)
                ->setParameter('dateFin', $dateFin);
        }

        if ($filtre['organisateur']) {
            $queryB->andWhere('sortie.organisateurs = :organisateur')
                ->setParameter('organisateur', $filtre['userId']);
        }

        if ($filtre['inscrit']) {
            $queryB->andWhere(':userId MEMBER OF sortie.participants')
                ->setParameter('userId', $filtre['userId']);
        }

        if ($filtre['nonInscrit']) {
            $queryB->andWhere(':userId NOT MEMBER OF sortie.participants')
                ->setParameter('userId', $filtre['userId'])
                ->andWhere('sortie.organisateurs != :organisateur')
                ->setParameter('organisateur', $filtre['userId']);
        }

//        if($filtre['passee']){
//
//        }
        $query = $queryB->getQuery();
        return $query->execute();
    }






//    /**
//     * @return Sortie[] Returns an array of Sortie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sortie
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
