<?php

namespace App\Repository;

use App\Entity\Location;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Location>
 *
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Location::class);
    }

    public function save(Location $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Location $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function searchLocationsByParams(array $params): ?array
    {

        $qb = $this->createQueryBuilder('l');
        $qbDate = $this->createQueryBuilder('l2');

        if($params['startAt'] && $params['endAt']) {
            $qbDate->join('l2.booking', 'bk')
                    ->where(':start < bk.endDateAt')
                    ->andWhere(':end > bk.startDateAt');
        }

        if ($params['travellerNumber']) {
            //jointures
            $qb->join("l.rooms", "r")
                ->join("r.roomBeds", "rb")
                ->join("rb.bed", "b");

            $qb->groupBy("l");

            $qb->having("SUM(b.capacity * rb.quantity) >= :travellerNumber")
                ->setParameter("travellerNumber", $params['travellerNumber']);
        }

        if ($params['where']) {
            $sql = 'SELECT ville_nom_simple, ville_latitude_deg, ville_longitude_deg FROM spec_villes_france where ville_nom_simple like :city';

            $statement = $this->getEntityManager()->getConnection()->prepare($sql);
            $execQuery = $statement->executeQuery([':city' => $params['where']]);
            $data = $execQuery->fetchAssociative();

            $qb->addSelect("ACOS(SIN(PI()*l.latitude/180.0)*SIN(PI()*:lat2/180.0)+COS(PI()*l.latitude/180.0)*COS(PI()*:lat2/180.0)*COS(PI()*:lon2/180.0-PI()*l.longitude/180.0))*6371 AS dist")
                ->setParameter(":lat2", $data["ville_latitude_deg"])
                ->setParameter(":lon2", $data["ville_longitude_deg"])
                ->orderBy("dist");
        }

        $qb->setParameter(":start", new \DateTime($params['startAt']))
           ->setParameter(":end", new \DateTime($params['endAt']))
           ->where($qb->expr()->notIn("l.id", $qbDate->getDQL()));

        return $qb->getQuery()->getResult();
    }



//    /**
//     * @return Location[] Returns an array of Location objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Location
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
