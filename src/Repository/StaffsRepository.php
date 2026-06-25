<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Staffs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StaffsRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry
    ) {
        parent::__construct(
            $registry,
            Staffs::class
        );
    }

    public function findStaffById(
        int $staffId
    ): ?Staffs {
        return $this->createQueryBuilder('s')
            ->where('s.staffId = :staffId')
            ->setParameter(
                'staffId',
                $staffId
            )
            ->getQuery()
            ->getOneOrNullResult();
    }
}