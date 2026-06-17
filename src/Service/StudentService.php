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
    ) {
    }

    public function createStudent(Request $request): array
    {
        $firstName = trim((string) $request->request->get('firstName', ''));
        $middleName = trim((string) $request->request->get('middleName', ''));
        $lastName = trim((string) $request->request->get('lastName', ''));
        $genderId = (int) $request->request->get('gender');
        $dob = (string) $request->request->get('dob', '');
        $email = trim((string) $request->request->get('email', ''));
        $phoneNumber = trim((string) $request->request->get('phoneNumber', ''));

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

        /*
         * Create Address
         */
        $address = new Address();

        $address->setEmailAddress($email);
        $address->setPhoneNumber($phoneNumber);

        $this->entityManager->persist($address);

        /*
         * Create Student
         */
        $student = new Students();

        $student->setFirstName($firstName);
        $student->setMiddleName($middleName);
        $student->setLastName($lastName);

        $student->setGender($gender);

        $student->setDob(
            new \DateTimeImmutable($dob)
        );

        $student->setAddress($address);

        $student->setUpn(
            $this->generateUpn()
        );

        $student->setCreatedAt(
            new \DateTimeImmutable()
        );

        $student->setModifiedAt(
            new \DateTimeImmutable()
        );

        $this->entityManager->persist($student);
        $this->entityManager->flush();

        return [
            'success' => true,
            'errors' => [],
        ];
    }

    private function generateUpn(): string
    {
        return 'UPN' . date('Y') . random_int(100000, 999999);
    }
}
