<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Academicyears;
use App\Entity\AttendanceCodes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AttendanceCodesRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct(
            $registry,
            AttendanceCodes::class
        );
    }

    public function findByAcademicYear(
        Academicyears $academicYear
    ): array {
        return $this->createQueryBuilder('ac')
            ->where('ac.academicYear = :academicYear')
            ->setParameter(
                'academicYear',
                $academicYear
            )
            ->orderBy('ac.code', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findPresentCode(
        Academicyears $academicYear,
        string $session
    ): ?AttendanceCodes {
        $code = $session === 'AM'
            ? '/'
            : '\\';

        return $this->createQueryBuilder('ac')
            ->where('ac.academicYear = :academicYear')
            ->andWhere('ac.code = :code')
            ->setParameter(
                'academicYear',
                $academicYear
            )
            ->setParameter(
                'code',
                $code
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findLateCodes(
        Academicyears $academicYear
    ): array {
        return $this->createQueryBuilder('ac')
            ->where('ac.academicYear = :academicYear')
            ->andWhere('ac.code IN (:codes)')
            ->setParameter(
                'academicYear',
                $academicYear
            )
            ->setParameter(
                'codes',
                [
                    'L',
                    'U',
                ]
            )
            ->orderBy('ac.code', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findAbsenceCodes(
        Academicyears $academicYear
    ): array {
        return $this->createQueryBuilder('ac')
            ->where('ac.academicYear = :academicYear')
            ->andWhere('ac.code NOT IN (:codes)')
            ->setParameter(
                'academicYear',
                $academicYear
            )
            ->setParameter(
                'codes',
                [
                    '/',
                    '\\',
                    'L',
                ]
            )
            ->orderBy('ac.code', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findCodeById(
        int $attendanceCodeId
    ): ?AttendanceCodes {
        return $this->createQueryBuilder('ac')
            ->where(
                'ac.attendance_code_id = :attendanceCodeId'
            )
            ->setParameter(
                'attendanceCodeId',
                $attendanceCodeId
            )
            ->getQuery()
            ->getOneOrNullResult();
    }
}