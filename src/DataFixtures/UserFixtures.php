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
        $user =new Users();
        
        $user->setEmail('chrisallen@waterford.com');
        $user->setPassword($this->passhasher->hashPassword($user,'chris123@waterford'));
        
        $manager->persist($user);
        $manager->flush();

    }
}
