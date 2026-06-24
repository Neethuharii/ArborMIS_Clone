<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Address;
use App\Entity\Staffs;
use App\Entity\CurrentRoles;
use App\Repository\GendersRepository;
use App\Repository\TitlesRepository;
use App\Repository\CurrentRolesRepository;
use App\Repository\BusinessrolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\StaffsRepository;

class StaffService
{
    public function __construct(
        private GendersRepository $gendersRepository,
        private TitlesRepository $titlesRepository,
        private CurrentRolesRepository $currentRolesRepository,
        private BusinessrolesRepository $businessRolesRepository,
        private EntityManagerInterface $entityManager,
        private StaffsRepository $staffsRepository
    ) {}

    public function getAllGenders(): array
    {
        return $this->gendersRepository->findAll();
    }

    public function getAllTitles(): array
    {
        return $this->titlesRepository->findAll();
    }

    public function getAllBusinessRoles(): array
    {
        return $this->businessRolesRepository->findAll();
    }

    public function getAllStaffs(): array
    {
        return $this->staffsRepository->findAll();
    }


    public function getStaffById(int $id): ?Staffs
    {
        return $this->staffsRepository->find($id);
    }

    public function addStaff(Request $request)
    {
        $genderId = $request->request->get('gender', 0);
        $firstName = $request->request->get('first_name');
        $middleName = $request->request->get('middle_name', '');
        $lastName = $request->request->get('last_name');
        $abbreviation = $request->request->get('abbreviation', '');
        $dateofBirth = $request->request->get('dob', '');
        $email = $request->request->get('email', '');
        $phoneNumber = $request->request->get('phone_number', '');
        $title = null;
        $titleId = $request->request->get('title', 0);
        $roleId = $request->request->get('roles', 0);

        $errors = [];

        if ($firstName === '') {
            $errors['firstName'] = 'Please enter your first name';
        }

        if ($lastName === '') {
            $errors['lastName'] = 'Please enter your last name';
        }

        if ($genderId === 0) {
            $errors['gender'] = 'Please select your gender.';
        }

        if ($dateofBirth === '') {
            $errors['dateofBirth'] = 'Please enter your date of birth.';
        }

        if ($email !== '') {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Enter a valid email address.';
            }
        }

        if ($phoneNumber !== '') {
            if (strlen($phoneNumber) !== 10) {
                $errors['phoneNumber'] = 'Phone Number must be exactly 10 digits.';
            }
        }

        $gender = $this->gendersRepository->find($genderId);

        if (!$gender) {
            return [
                'success' => false,
                'errors' => [
                    'gender' => 'Invalid gender selected.',
                ],
            ];
        }

        if ($titleId > 0) {
            $title = $this->titlesRepository->find($titleId);
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors,
            ];
        }

        $staff = new Staffs();
        $address = new Address();

        $staff->setFirstName($firstName);
        $staff->setMiddleName($middleName ?: null);
        $staff->setLastName($lastName);
        $staff->setTitle($title);
        $staff->setGender($gender);
        $staff->setAbbreviation($abbreviation ?: null);
        $staff->setDateOfBirth(new \DateTimeImmutable($dateofBirth));
        $staff->setAddress($address);
        $staff->setCreatedAt(new \DateTimeImmutable());
        $staff->setModifiedAt(new \DateTimeImmutable());
        $this->entityManager->persist($staff);

        $address->setEmailAddress($email);
        $address->setPhoneNumber($phoneNumber);
        $address->setCreatedAt(new \DateTimeImmutable());
        $address->setModifiedAt(new \DateTimeImmutable());

        $this->entityManager->persist($address);

        $businessRole = $this->businessRolesRepository->find($roleId);

        if (!$businessRole) {
            return [
                'success' => false,
                'errors' => [
                    'role' => 'Invalid role selected.'
                ]
            ];
        }

        $roleHistory = new CurrentRoles();
        $roleHistory->setStaff($staff);
        $roleHistory->setBusinessRole($businessRole);
        $roleHistory->setStartDate(new \DateTimeImmutable());
        $roleHistory->setCreatedAt(new \DateTimeImmutable());
        $roleHistory->setModifiedAt(new \DateTimeImmutable());
        $this->entityManager->persist($roleHistory);

        $this->entityManager->flush();

        $staff->setCurrentRole($roleHistory);
        $this->entityManager->flush();

        return [
            'success' => true,
            'errors' => [],
        ];
    }
}
