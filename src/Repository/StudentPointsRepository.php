<?php

namespace App\Repository;

use App\Entity\StudentPoints;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudentPoints>
 */
class StudentPointsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StudentPoints::class);
    }

    //    /**
    //     * @return StudentPoints[] Returns an array of StudentPoints objects
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

    //    public function findOneBySomeField($value): ?StudentPoints
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function searchTotalPoints(string $search): array
    {
        return $this->createQueryBuilder('sp')
            ->select(
                's.firstName AS firstName',
                's.lastName AS lastName',
                'sp.totalPoints AS totalPoints'
            )
            ->join('sp.student', 's')
            ->where('LOWER(s.firstName) LIKE LOWER(:search)
                OR LOWER(s.lastName) LIKE LOWER(:search)')
            ->setParameter('search', '%' . $search . '%')
            ->orderBy('s.firstName', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
