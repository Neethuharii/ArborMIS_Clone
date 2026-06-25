<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Attendances;
use App\Entity\StudentEnrollments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AttendancesRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct(
            $registry,
            Attendances::class
        );
    }

    public function findAttendance(
        StudentEnrollments $enrollment,
        \DateTime $date,
        string $session
    ): ?Attendances {
        return $this->createQueryBuilder('a')
            ->where('a.studentEnrollment = :enrollment')
            ->andWhere('a.attendance_date = :date')
            ->andWhere('a.session = :session')
            ->setParameter('enrollment', $enrollment)
            ->setParameter('date', $date->format('Y-m-d'))
            ->setParameter('session', $session)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByDateAndSession(
        \DateTime $date,
        string $session
    ): array {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.studentEnrollment', 'se')
            ->leftJoin('se.student', 's')
            ->addSelect('se')
            ->addSelect('s')
            ->where('a.attendance_date = :date')
            ->andWhere('a.session = :session')
            ->setParameter('date', $date->format('Y-m-d'))
            ->setParameter('session', $session)
            ->getQuery()
            ->getResult();
    }
}