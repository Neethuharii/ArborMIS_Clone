<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\BusinessRoles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class RoleFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $values = [
            'Administration Assistant','Admission Officer','Advisory Teacher','Art/Design Technician',
            'Assistant Head Teacher','Attendance Officer','Behaviour Manager/Specialist','Bursar/Business Manager',
            'Careers Advisor','Child Protection Liaison Officer','Childcare Officer'
        ];
        
        $salaryValues = [25000, 30000, 35000, 40000, 45000, 50000, 55000, 60000, 65000, 70000, 75000];
        
        foreach($values as $index => $roleName) {
            $role = new BusinessRoles();
            $role->setNameOfRole($roleName);
            $role->setSalary($salaryValues[$index]);
            $manager->persist($role);
        }
        $manager->flush();
    }
    public static function getGroups():array
    {
        return ['role-fixture'];
    }
}
