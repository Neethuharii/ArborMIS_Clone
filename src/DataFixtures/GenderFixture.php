<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Genders;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenderFixture extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $gender =new Genders();
        $gender->setGenderType('Male');
        $manager->persist($gender);

        $gender1=new Genders();
        $gender1->setGenderType('Female');
        $manager->persist($gender1);

        $gender2=new Genders();
        $gender2->setGenderType('Not Known');
        $manager->persist($gender2);

        $gender3=new Genders();
        $gender3->setGenderType('Not Specified');
        $manager->persist($gender);
        $manager->flush();
    }
}
