<?php

namespace App\Repository;

use App\Entity\Academicyears;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTimeImmutable;

class AcademicyearsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Academicyears::class);
    }

    public function findCurrentAcademicYear(): ?Academicyears
    {
        return $this->createQueryBuilder('a')
            ->where('a.start_date <= :today')
            ->andWhere('a.end_date >= :today')
            ->setParameter('today', new DateTimeImmutable())
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findAcademicYearByDate(DateTimeImmutable $selectedDate): ?Academicyears
    {
        return $this->createQueryBuilder('a')
            ->Where('a.start_date <= :date')
            ->andWhere('a.end_date >= :date')
            ->setParameter('date',$selectedDate)
            ->getQuery()
            ->getOneOrNullResult();
    }
}