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
        $query = $this->createQueryBuilder('sortie');

        if ($filtre['campus']) {
            $query->andWhere('sortie.siteOrganisateur = :campus')
                  ->setParameter('campus', $filtre['campus']);
        }

        if ($filtre['nom']) {
            $query->andWhere('sortie.nom LIKE :nom')
                  ->setParameter('nom', '%' . $filtre['nom'] . '%');
        }

        if ($filtre['dateDebut'] || $filtre['dateFin']) {
            $dateDebut = $filtre['dateDebut'] ? date_format($filtre['dateDebut'], 'd-m-Y') : date('d-m-Y');
            $dateFin = $filtre['dateFin'] ? date_format($filtre['dateFin'], 'd-m-Y') : date('d-m-Y');
            $query->andWhere('sortie.dateHeureDebut BETWEEN :dateDebut and :dateFin')
                  ->setParameter('dateDebut', $dateDebut)
                  ->setParameter('dateFin', $dateFin);
        }

        if ($filtre['organisateur']) {
            $query->andWhere('sortie.organisateurs = :organisateur')
                  ->setParameter('organisateur', $filtre['userID']);
        }

        if($filtre['inscrit']){
            $query ->andWhere(':userID MEMBER OF sortie.isInscrit')
                   ->setParameter('userID', $filtre['userID']);
        }

        if($filtre['nonInscrit']) {
            $query->andWhere(':userId NOT MEMBER OF sortie.isInscrit')
                  ->setParameter('userID', $filtre['userID'])
                  ->andWhere('sortie.organisateurs != :organisateur')
                  ->setParameter('organisateur', $filtre['userID']);
        }

        if($filtre['passee']){

        }



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
