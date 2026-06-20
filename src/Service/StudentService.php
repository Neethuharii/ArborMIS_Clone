<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Address;
use App\Entity\Students;
use App\Repository\CountriesRepository;
use App\Repository\EthnicitiesRepository;
use App\Repository\GendersRepository;
use App\Repository\NationalityRepository;
use App\Repository\ReligionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

final class StudentService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly GendersRepository $gendersRepository,
        private readonly CountriesRepository $countriesRepository,
        private readonly EthnicitiesRepository $ethnicitiesRepository,
        private readonly NationalityRepository $nationalityRepository,
        private readonly ReligionsRepository $religionsRepository,
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

    public function listAllStudent(string $search)
    {
        $repository = $this->entityManager->getRepository(Students::class);

        if ($search === '') {
            return $repository->findBy([], ['studentId' => 'DESC']);
        }

        return $repository->createQueryBuilder('s')
            ->where('s.firstName LIKE :search')
            ->orWhere('s.lastName LIKE :search')
            ->setParameter('search', '%' . $search . '%')
            ->orderBy('s.studentId', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getStudentById(int $studentId): ?Students
    {
        return $this->entityManager
            ->getRepository(Students::class)
            ->find($studentId);
    }
    public function getEditData(int $studentId, string $field): array
    {
        $student = $this->getStudentById($studentId);

        if (!$student) {
            throw new \RuntimeException('Student not found.');
        }

        $value = match ($field) {

            'firstName' => $student->getFirstName(),
            'middleName' => $student->getMiddleName(),
            'lastName' => $student->getLastName(),
            'upn' => $student->getUpn(),
            'dob' => $student->getDob()?->format('Y-m-d'),

    
            'country' => $student->getCountry()?->getCountryId(),
            'religion' => $student->getReligion()?->getReligionId(),
            'ethnicity' => $student->getEthnicity()?->getEthnicityId(),
            'nationality' => $student->getNationality()?->getNationalityId(),

            default => ''
        };

        return [
            'student' => $student,
            'field' => $field,
            'value' => $value,

           
            'countries' => $this->countriesRepository->findAll(),
            'religions' => $this->religionsRepository->findAll(),
            'ethnicities' => $this->ethnicitiesRepository->findAll(),
            'nationalities' => $this->nationalityRepository->findAll(),
        ];
    }
    public function updateField(int $studentId, string $field, mixed $value): void
    {
        $student = $this->getStudentById($studentId);

        if (!$student) {
            throw new \RuntimeException('Student not found.');
        }

        match ($field) {

            'firstName' => $student->setFirstName((string) $value),
            'middleName' => $student->setMiddleName((string) $value),
            'lastName' => $student->setLastName((string) $value),
            'upn' => $student->setUpn((string) $value),

            'dob' => $student->setDob(new \DateTimeImmutable((string) $value)),

            // RELATIONS (VERY IMPORTANT)
            'country' => $student->setCountry(
                $this->countriesRepository->find($value)
            ),

            'religion' => $student->setReligion(
                $this->religionsRepository->find($value)
            ),

            'ethnicity' => $student->setEthnicity(
                $this->ethnicitiesRepository->find($value)
            ),

            'nationality' => $student->setNationality(
                $this->nationalityRepository->find($value)
            ),

            default => throw new \InvalidArgumentException("Field not editable")
        };

        $student->setModifiedAt(new \DateTimeImmutable());

        $this->entityManager->flush();
    }
}
