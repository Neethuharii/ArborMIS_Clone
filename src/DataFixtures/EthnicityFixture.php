<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Ethnicities;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class EthnicityFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $values = [
            'African',
            'African Asian',
            'Afghan',
            'Albanian',
            'Any other american background',
            'Arab',
            'Bangladeshi',
            'Caribbean',
            'Chinese',
            'Indian',
            'Other Asian',
            'Other Black',
            'Other Ethnic Group',
            'Other Mixed',
            'Pakistani',
            'Prefer not to say',
            'White - Irish',
            'White - Irish Traveller',
            'White - Other',
            'White and Asian',
            'White and Black African',
            'White and Black Caribbean',
            'White-British',
        ];
        
        foreach ($values as $ethnicityName) {
            $ethnicity = new Ethnicities();
            $ethnicity->setEthnicityName($ethnicityName);
            $manager->persist($ethnicity);
        }
        $manager->flush();
    }
    public static function getGroups():array
    {
        return ['ethnicity-fixture'];
    }
}
