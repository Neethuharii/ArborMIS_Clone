<?php

declare(strict_types=1);

namespace App\DataFixtures;
use App\Entity\Interventions;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Override;

class InterventionFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $interventionMethods = [
            'Wrap Hold',
            'Two person single elbow',
            'Shield escort to safe space',
            'Front ground'
        ];

        foreach($interventionMethods as $method){
            
            $intervention = new Interventions();
            $intervention->setInterventionMethod($method);
            $manager->persist($intervention);

        }
        $manager->flush();
    }
    
    public static function getGroups(): array
    {
        return ['intervention-fixture'];
    }
}

