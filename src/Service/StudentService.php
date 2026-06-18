<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Address;
use App\Entity\Students;
use App\Repository\GendersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class StudentService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly GendersRepository $gendersRepository
    ) {}

    public function createStudent(Request $request): array
    {
        $firstName =  $request->request->get('firstName', '');
        $middleName = $request->request->get('middleName', '');
        $lastName =  $request->request->get('lastName', '');
        $genderId = $request->request->get('gender');
        $dob =  $request->request->get('dob', '');
        $email =  $request->request->get('email', '');
        $phoneNumber = $request->request->get('phoneNumber', '');

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
            if(strlen($phoneNumber) !== 10) {
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

        $address = new Address();
        $address->setEmailAddress($email);
        $address->setPhoneNumber($phoneNumber);
        $address->setCreatedAt(new \DateTimeImmutable());
        $address->setModifiedAt(new \DateTimeImmutable());

        $this->entityManager->persist($address);

        $student = new Students();
        $student->setFirstName($firstName);
        $student->setMiddleName($middleName);
        $student->setLastName($lastName);
        $student->setGender($gender);
        $student->setDob(new \DateTimeImmutable($dob));
        $student->setAddress($address);
        $student->setCreatedAt(new \DateTimeImmutable());
        $student->setModifiedAt(new \DateTimeImmutable());

        $this->entityManager->persist($student);
        $this->entityManager->flush();

        return [
            'success' => true,
            'errors' => [],
        ];
    }
}
