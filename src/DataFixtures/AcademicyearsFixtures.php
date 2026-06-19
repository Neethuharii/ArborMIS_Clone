<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Academicyears;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class AcademicyearsFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $academicYears = [
            ['2023-2024', '2023-09-01', '2024-07-31'],
            ['2024-2025', '2024-09-01', '2025-07-31'],
            ['2025-2026', '2025-09-01', '2026-07-31'],
        ];

        foreach ($academicYears as [$name, $startDate, $endDate]) {
            $academicYear = new Academicyears();

            $academicYear->setName($name);
            $academicYear->setStartDate(new \DateTimeImmutable($startDate));
            $academicYear->setEndDate(new \DateTimeImmutable($endDate));
            $academicYear->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($academicYear);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['academic-year-fixture'];
    }
}