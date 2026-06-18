<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Titles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class TitleFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $values = [
            'Archbishop','Archdeacon','Baron','Baroness','Bishop','Br','Captain','Cllr','Colonel','Commander',
            'Count','Countess','Dame','Dr','Fr','Lady','Lieutenant','Lieutenant Colonel','Lord','Major','Miss',
            'Mr','Mrs','Ms','Mx','Pr','Prof','Rabbi','Rev','Sergeant','Sir','Sister','The Honorable','Ven'
        ];
        
        foreach($values as $titleName) {
            $title = new Titles();
            $title->setTitleName($titleName);
            $manager->persist($title);
        }
        $manager->flush();
    }
    public static function getGroups():array
    {
        return ['title-fixture'];
    }
}
