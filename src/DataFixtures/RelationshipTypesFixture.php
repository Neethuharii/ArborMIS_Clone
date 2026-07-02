<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\RelationshipTypes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class RelationshipTypesFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $relationType = [
            'Adoptive parents',
            'Adoptive son',
            'Advisor',
            'Aunt',
            'Brother (half)',
            'Brother (natural or adoptive)',
            'Brother (step)',
            'Brother-in-law',
            'Daughter',
            'Daughter-in-law',
            'Doctor',
            'Educational guardian',
            'Employer',
            'Family Support Worker',
            'Family member',
            'Father (foster)',
            'Father (natural or adoptive)',
            'Father (step)',
            "Father's significant other",
            'Father-in-law',
            'Fiancé',
            'Fiancée',
            'Former husband',
            'Former wife',
            'Foster brother',
            'Foster parent',
            'Foster sister',
            'Friend',
            'Godfather',
            'Godmother',
            'Godparent',
            'Granddaughter',
            'Grandfather',
            'Grandmother',
            'Grandparent',
            'Grandson',
            'Great aunt',
            'Great uncle',
            'Great-grandfather',
            'Life partner',
            'Life partner of parent',
            'Mother (foster)',
            'Mother (natural or adoptive)',
            'Mother (step)',
            'Mother-in-law',
            'Neighbour',
            'Nephew',
            'Niece',
            'None'
        ];

        foreach ($relationType as $relationTypeName) {
            $relationType = new RelationshipTypes();
            $relationType->setRelationshipTypeName($relationTypeName);
            $manager->persist($relationType);
        }
        $manager->flush();
    }
    public static function getGroups(): array
    {
        return ['relationshipType-fixture'];
    }
}
