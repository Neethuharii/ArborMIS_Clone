<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Behaviours;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BehaviourFixture extends Fixture implements FixtureGroupInterface, DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $behaviours=[
            ['Physical abuse','Level 5 negative'],
            ['Bullying','Level 4 negative'],
            ['Theft','Level 3 negative'],
            ['Smoking','Level 2 negative'],
            ['Unkind behaviour','Level 1 negative'],
            ['Bumped head','Level 0 neutral'],
            ['Showing resilience', 'Level 1 positive'],
            ['Helping fellow peers','Level 2 positive'],
            ['Working on school project after class','Level 3 positive'],
            ['Showing courage in the face of adversity','Level 4 positive'],
            ['Headteacher Award','Level 5 positive']
        ];

        foreach($behaviours as [$behaviourName,$categoryName])
        {
            $behaviour = new Behaviours();

            $behaviour->setBehaviourName($behaviourName);
            $behaviour->setCategory(
                $this->getReference($categoryName, Categories::class)
            );
            $manager->persist($behaviour);
        }

        $manager->flush();

    }

    public function getDependencies(): array
    {
        return[ CategoryFixture::class];       
    }
    public static function getGroups(): array
    {
        return ['behaviour-fixture'];
    }
}
