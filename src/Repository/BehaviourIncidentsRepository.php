<?php

namespace App\Repository;

use App\Entity\BehaviourIncidents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BehaviourIncidents>
 */
class BehaviourIncidentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BehaviourIncidents::class);
    }

    //    /**
    //     * @return BehaviourIncidents[] Returns an array of BehaviourIncidents objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BehaviourIncidents
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function searchRecentPoints(string $search): array
    {
        return $this->createQueryBuilder('i')
            ->select(
                's.firstName AS firstName',
                's.lastName AS lastName',
                'i.incidentDate AS incidentDate',
                'c.categoryName AS category',
                'c.categoryPoints AS points',
                'b.behaviourName AS narrative'
            )
            ->join('i.studentInvolved', 's')
            ->join('i.behaviour', 'b')
            ->join('b.category', 'c')
            ->andWhere('LOWER(s.firstName) LIKE LOWER(:search)
                    OR LOWER(s.lastName) LIKE LOWER(:search)')
            ->setParameter('search', '%' . $search . '%')
            ->orderBy('i.incidentDate', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }

    
}
