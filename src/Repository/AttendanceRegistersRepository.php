<?php

namespace App\Repository;

use App\Entity\AttendanceRegisters;
use App\Entity\Classrooms;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTimeInterface;
/**
 * @extends ServiceEntityRepository<AttendanceRegisters>
 */
class AttendanceRegistersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttendanceRegisters::class);
    }

    public function findByClassroomDateSession(
    Classrooms $classroom,
    DateTimeInterface $date,
    string $session
): ?AttendanceRegisters {
    return $this->createQueryBuilder('r')
        ->andWhere('r.classroom = :classroom')
        ->andWhere('r.attendance_date = :date')
        ->andWhere('r.session = :session')
        ->setParameter('classroom', $classroom)
        ->setParameter('date', $date->format('Y-m-d'))
        ->setParameter('session', $session)
        ->getQuery()
        ->getOneOrNullResult();
}
    
}
