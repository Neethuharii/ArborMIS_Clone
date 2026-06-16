<?php

namespace App\DataFixtures;

use App\Entity\Genders;
use App\Entity\Users;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GenderFixture extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $passhasher){
    }

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
        $manager->flush();

        $gender2=new Genders();
        $gender2->setGenderType('Not Specified');
        $manager->persist($gender2);
        $manager->flush();

    }
}
