<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\SuspensionReasons;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class SuspensionFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager):void
    {
        $suspensionReasons=[
            'Bullying',
            'Racist abuse',
            'Damage',
            'Drug dealing',
            'Physical assault',
            'Smoking',
            'Vandalism'
        ];

        foreach($suspensionReasons as $reason){
            $suspensionReason = new SuspensionReasons();
            $suspensionReason->setSuspensionReason($reason);
            $manager->persist($suspensionReason);
        }
        $manager->flush();
    }
    public static function getGroups():array
    {
        return ['suspension-fixture'];
    }
}

