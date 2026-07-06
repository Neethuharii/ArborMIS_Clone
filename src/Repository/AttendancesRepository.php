<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Attendances;
use App\Entity\StudentEnrollments;
use App\Entity\Classrooms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTimeInterface;
use DateTime;

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
        DateTime $date,
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

    public function countMarkedForClassroomDateSession(
        Classrooms $classroom,
        DateTimeInterface $date,
        string $session
    ): int {
        return (int) $this->createQueryBuilder('a')
            ->select('COUNT(a.attendance_id)')
            ->join('a.studentEnrollment', 'e')
            ->andWhere('e.classroom = :classroom')
            ->andWhere('a.attendance_date = :date')
            ->andWhere('a.session = :session')
            ->setParameter('classroom', $classroom)
            ->setParameter('date', $date->format('Y-m-d'))
            ->setParameter('session', $session)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
