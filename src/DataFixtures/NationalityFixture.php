<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Nationality;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class NationalityFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $status = [
            'Asylum Seeker',
            'British National (Overseas)',
            'British Overseas Citizen',
            'British Overseas Territories Citizen',
            'British Protected Person Status',
            'British Subject',
            'Citizen',
            'Non-Permanent Resident',
            'Not applicable',
            'Permanent Resident',
            'Refugee',
            'Unknown'
        ];
        
        foreach($status as $nationalityName){
            $nationalityStatus = new Nationality();
            $nationalityStatus->setNationalityStatus($nationalityName);
            $manager->persist($nationalityStatus);
        }
        $manager->flush();
    }
    public static function getGroups():array
    {
        return ['nationality-fixture'];
    }
}
