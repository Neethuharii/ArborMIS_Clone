<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\QualificationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class QualificationTypeFixtures extends Fixture implements FixtureGroupInterface 
{
    public function load(ObjectManager $manager): void
    {
        $qualificationTypes = [
            'Check: Academic Qualifications',
            'Check: Address Check',
            'Check: Character References'
        ];

        foreach ($qualificationTypes as $qualificationTypeName) {
            $entity = new QualificationType();
            $entity->setQualificationName($qualificationTypeName);
            
            $manager->persist($entity);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['qualificationTypes-fixture'];
    }
}
