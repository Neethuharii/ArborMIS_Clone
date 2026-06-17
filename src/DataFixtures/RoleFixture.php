<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\BusinessRoles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $values = [
            'Administration Assistant','Admission Officer','Advisory Teacher','Art/Design Technician',
            'Assistant Head Teacher','Attendance Officer','Behaviour Manager/Specialist','Bursar/Business Manager',
            'Careers Advisor','Child Protection Liaison Officer','Childcare Officer'
        ];
        
        $salaryValues = [25000, 30000, 35000, 40000, 45000, 50000, 55000, 60000, 65000, 70000, 75000];
        
        for ($i = 0; $i < count($values); $i++) {
            $role = new BusinessRoles();
            $role->setNameOfRole($values[$i]);
            $role->setSalary($salaryValues[$i]);
            $manager->persist($role);
        }
        $manager->flush();
    }
}
