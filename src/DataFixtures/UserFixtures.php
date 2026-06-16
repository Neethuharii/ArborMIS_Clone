<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $passhasher){
    }

    public function load(ObjectManager $manager): void
    {
        $user1 =new Users();
        
        $user1->setEmail('chrisallen@waterford.com');
        $user1->setPassword($this->passhasher->hashPassword($user1,'chris123@waterford'));
        $manager->persist($user1);

        $user2 =new Users();
        $user2->setEmail('dennisbarton@waterford.com');
        $user2->setPassword($this->passhasher->hashPassword($user2,'dennis123@waterford'));
        $manager->persist($user2);

        $user3 =new Users();
        $user3->setEmail('staceychapman@waterford.com');
        $user3->setPassword($this->passhasher->hashPassword($user3,'stacey123@waterford'));
        $manager->persist($user3);

        $user4 =new Users();
        $user4->setEmail('zachcook@waterford.com');
        $user4->setPassword($this->passhasher->hashPassword($user4,'zach123@waterford'));
        $manager->persist($user4);

        $user5 =new Users();
        $user5->setEmail('janedoe@waterford.com');
        $user5->setPassword($this->passhasher->hashPassword($user5,'jane123@waterford'));
        $manager->persist($user5);

        $user6 =new Users();
        $user6->setEmail('johnben@waterford.com');
        $user6->setPassword($this->passhasher->hashPassword($user6,'john123@waterford'));
        $manager->persist($user6);

        $manager->flush();

    }
}
