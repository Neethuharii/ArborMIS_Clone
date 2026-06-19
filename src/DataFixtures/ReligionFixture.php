<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Religions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class ReligionFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $religions = [
            'Atheism',
            'Buddhism',
            'Christianity',
            'Hinduism',
            'Islam',
            'Jainism',
            'Judaism',
            'No Religion',
            'Sikhism',
            'Other',
        ];

        foreach ($religions as $religionName) {
            $religion = new Religions();
            $religion->setReligionName($religionName);

            $manager->persist($religion);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['religion-fixture'];
    }
}
