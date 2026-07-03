<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\FundingTypes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class FundingTypeFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $types = [
            'Adult Education Bursary',
            'Adult Learning Grant',
            'Care to Learn',
            'Disability Access Fund (DAF)',
            'Discretionary Bursary Awarded',
            'Exceptional Needs Funding',
            'Free Childcare for Training & Learning for Work',
            'Learner repeating up to one full year of 16-19 funded provision',
            'Professional and Career Development Loan',
            'Programmed Led Apprenticeships hardship fund',
            'Time off for study',
            'Top-up Funding',
            'Tutoring (formeRly NTP)',
            'Vulnerable Group Bursary Awarded'
        ];

        foreach ($types as $fundingType) {
            $fundingTypeName = new FundingTypes();
            $fundingTypeName->setFundingTypeName($fundingType);
            $manager->persist($fundingTypeName);
        }
        $manager->flush();
    }
    public static function getGroups(): array
    {
        return ['funding-type-fixture'];
    }
}
