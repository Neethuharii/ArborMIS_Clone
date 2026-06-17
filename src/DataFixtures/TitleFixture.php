<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Titles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TitleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $values = [
            'Archbishop','Archdeacon','Baron','Baroness','Bishop','Br','Captain','Cllr','Colonel','Commander',
            'Count','Countess','Dame','Dr','Fr','Lady','Lieutenant','Lieutenant Colonel','Lord','Major','Miss',
            'Mr','Mrs','Ms','Mx','Pr','Prof','Rabbi','Rev','Sergeant','Sir','Sister','The Honorable','Ven'
        ];
        
        for ($i = 0; $i < count($values); $i++) {
            $title = new Titles();
            $title->setTitleName($values[$i]);
            $manager->persist($title);
        }
        $manager->flush();
    }
}
