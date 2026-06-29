<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\DocumentTypes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class DocumentTypesFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $documentTypes = [
           'Asylum Seeker Reference Number',
           'Birth Certificate',
           'Driving License',
           'National Identity Card',
           'National Insurance Number',
           'Passport',
           'Teacher Number',
           'Visa'   
        ];

        foreach ($documentTypes as $document) {
            $documentType= new DocumentTypes();
            $documentType->setDocumentTypeName($document);
            $manager->persist($documentType);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['documentType-fixture'];
    }
}
