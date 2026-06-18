<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Address;
use App\Entity\Staffs;
use App\Repository\GendersRepository;
use App\Repository\TitlesRepository;
use App\Repository\BusinessrolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class StaffService
{
    private GendersRepository $gendersRepository;
    private TitlesRepository $titlesRepository;
    private BusinessrolesRepository $businessRolesRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(GendersRepository $GendersRepository, TitlesRepository $TitlesRepository, BusinessrolesRepository $BusinessrolesRepository, EntityManagerInterface $entityManager)
    {
        $this->gendersRepository = $GendersRepository;
        $this->titlesRepository = $TitlesRepository;
        $this->businessRolesRepository = $BusinessrolesRepository;
        $this->entityManager = $entityManager;
    }

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

    public function addStaff(Request $request)
    {
        $genderId = $request->request->get('gender', 0);
        $firstName = $request->request->get('first_name');
        $middleName = $request->request->get('middle_name', '');
        $lastName = $request->request->get('last_name');
        $abbreviation = $request->request->get('abbreviation', '');
        $dob = $request->request->get('dob', '');
        $email = $request->request->get('email', '');
        $phoneNumber = $request->request->get('phone_number', '');
        $title = null;
        $titleId = $request->request->get('title', 0);

        $errors = [];

        if ($firstName === '') {
            $errors['firstName'] = 'First Name is required.';
        }

        if ($lastName === '') {
            $errors['lastName'] = 'Last Name is required.';
        }

        if ($genderId === 0) {
            $errors['gender'] = 'Gender is required.';
        }

        if ($dob === '') {
            $errors['dob'] = 'Date of Birth is required.';
        }

        if ($email !== '') {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Please enter a valid email address.';
            }
        }

        if ($phoneNumber !== '') {
            if (strlen($phoneNumber) !== 10) {
                $errors['phoneNumber'] = 'Phone Number must be exactly 10 digits.';
            }
        }

        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors,
            ];
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

        $address = new Address();
        $address->setEmailAddress($email);
        $address->setPhoneNumber($phoneNumber);
        $address->setCreatedAt(new \DateTimeImmutable());
        $address->setModifiedAt(new \DateTimeImmutable());

        $this->entityManager->persist($address);

        $staff = new Staffs();
        $staff->setFirstName($firstName);
        $staff->setMiddleName($middleName ?: null);
        $staff->setLastName($lastName);
        $staff->setTitle($title);
        $staff->setGender($gender);
        $staff->setAbbreviation($abbreviation ?: null);
        $staff->setDateOfBirth(new \DateTimeImmutable($dob));
        $staff->setAddress($address);
        $staff->setCreatedAt(new \DateTimeImmutable());
        $staff->setModifiedAt(new \DateTimeImmutable());

        $this->entityManager->persist($staff);
        $this->entityManager->flush();

        return [
            'success' => true,
            'errors' => [],
        ];
    }
}
