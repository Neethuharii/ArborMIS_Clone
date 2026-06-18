<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Holidays;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class HolidaysFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $holidays = [
            ['New Year', '2026-01-01', '2026-01-01'],
            ['Good Friday', '2026-04-03', '2026-04-03'],
            ['Easter Monday', '2026-04-06', '2026-04-06'],
            ['Labour Day', '2026-05-01', '2026-05-01'],
            ['Christmas Day', '2026-12-25', '2026-12-25'],
        ];

        foreach ($holidays as [$name, $fromDate, $toDate]) {
            $holiday = new Holidays();
            $holiday->setHolidayName($name);
            $holiday->setFromDate(new \DateTimeImmutable($fromDate));
            $holiday->setToDate(new \DateTimeImmutable($toDate));
            $holiday->setCreatedAt(new \DateTimeImmutable());

            $manager->persist($holiday);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['holiday-fixture'];
    }
}