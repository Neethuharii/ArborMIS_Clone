<?php

namespace App\Repository;

use App\Entity\SuspensionDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SuspensionDetails>
 */
class SuspensionDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SuspensionDetails::class);
    }

    //    /**
    //     * @return SuspensionDetails[] Returns an array of SuspensionDetails objects
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

    //    public function findOneBySomeField($value): ?SuspensionDetails
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function getSuspensionStatistics(): array
    {
        return $this->createQueryBuilder('s')
            ->select('st.firstName', 'st.lastName')
            ->addSelect('COUNT(s.suspensionDetailId) AS totalSuspensions')
            ->addSelect('SUM(s.daysLost) AS totalDaysLost')
            ->join('s.student', 'st')
            ->groupBy('st.studentId')
            ->getQuery()
            ->getArrayResult();
    }
}
