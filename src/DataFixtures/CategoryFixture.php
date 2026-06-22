<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            ['Level 5 negative', -5],
            ['Level 4 negative', -4],
            ['Level 3 negative', -3],
            ['Level 2 negative', -2],
            ['Level 1 negative', -1],
            ['Level 0 neutral', 0],
            ['Level 1 positive', 1],
            ['Level 2 positive', 2],
            ['Level 3 positive', 3],
            ['Level 4 positive', 4],
            ['Level 5 positive', 5]
        ];

        foreach($categories as [$name,$points]){
            
            $category = new Categories();
            $category->setCategoryName($name);
            $category->setCategoryPoints($points);
            $manager->persist($category);
            $this->addReference($name,$category);
            
        }
        $manager->flush();
    }
    public static function getGroups():array
    {
        return ['category-fixture'];
    }
}