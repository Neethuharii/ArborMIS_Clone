<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Address;
use App\Entity\Cards;
use App\Entity\Documents;
use App\Entity\Guardian;
use App\Entity\StudentGuardianRelation;
use App\Entity\Students;
use App\Repository\CountriesRepository;
use App\Repository\DocumentTypesRepository;
use App\Repository\EthnicitiesRepository;
use App\Repository\GendersRepository;
use App\Repository\NationalityRepository;
use App\Repository\RelationshipTypesRepository;
use App\Repository\ReligionsRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
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
        private readonly DocumentTypesRepository $documentTypesRepository,
        private readonly RelationshipTypesRepository $relationshipTypesRepository
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

    public function updateStudent(Students $student, Request $request): void
    {
        $genderId = $request->request->get('gender');

        if ($genderId) {
            $gender = $this->gendersRepository->find($genderId);
            $student->setGender($gender);
        }

        $countryId = $request->request->get('country');

        if ($countryId) {
            $country = $this->countriesRepository->find($countryId);
            $student->setCountry($country);
        }

        $ethnicityId = $request->request->get('ethnicity');

        if ($ethnicityId) {
            $ethnicity = $this->ethnicitiesRepository->find($ethnicityId);
            $student->setEthnicity($ethnicity);
        }

        $nationalitId = $request->request->get('nationality');

        if ($nationalitId) {
            $nationality = $this->nationalityRepository->find($nationalitId);
            $student->setNationality($nationality);
        }

        $religionId = $request->request->get('religion');

        if ($religionId) {
            $religion = $this->religionsRepository->find($religionId);
            $student->setReligion($religion);
        }

        $firstName = $request->request->get('firstName');
        if ($firstName !== null) {
            $student->setFirstName($firstName);
        }

        $middleName = $request->request->get('middleName');
        if ($middleName !== null) {
            $student->setMiddleName($middleName);
        }

        $lastName = $request->request->get('lastName');
        if ($lastName !== null) {
            $student->setLastName($lastName);
        }

        $dob = $request->request->get('dob');
        if ($dob !== null) {
            $student->setDob(new DateTimeImmutable($dob));
        }
        $documentTypeId = $request->request->get('documentType');
        $documentNumber = $request->request->get('documentNumber');
        if ($documentTypeId && $documentNumber) {
            $document = $student->getDocument();
            if (!$document) {
                $document = new Documents();
            }
            $documentType = $this->documentTypesRepository->find($documentTypeId);
            if (!$documentType) {
                throw new Exception('Invalid document type.');
            }
            $document->setDocumentNumber($documentNumber);
            $document->setDocumentType($documentType);
            $issueDate = $request->request->get('issueDate');
            if ($issueDate) {
                $document->setIssueDate(new DateTimeImmutable($issueDate));
            }
            $expiryDate = $request->request->get('expiryDate');
            if ($expiryDate) {
                $document->setExpiryDate(new DateTimeImmutable($expiryDate));
            }
            $document->setModifiedAt(new DateTimeImmutable());
            $this->entityManager->persist($document);
            $student->setDocument($document);
        }
        $cardNumber = $request->request->get('cardNumber');

        if ($cardNumber) {
            $card = $student->getCard();
            if (!$card) {
                $card = new Cards();
            }
            $card->setCardNumber($cardNumber);
            $card->setStatus($request->request->getBoolean('status'));
            $issuedDate = $request->request->get('issuedDate');
            $issuedTime = $request->request->get('issuedTime');
            if ($issuedDate && $issuedTime) {
                $card->setIssuedAt(
                    new DateTimeImmutable($issuedDate . ' ' . $issuedTime)
                );
            }
            $card->setModifiedAt(new DateTimeImmutable());
            $this->entityManager->persist($card);
            $student->setCard($card);
        }
        $student->setModifiedAt(new DateTimeImmutable());
        $this->entityManager->flush();
    }

    public function createGuardianForStudent(array $data, Students $student, Request $request): Guardian
    {
        if (empty($data['firstName']) || empty($data['lastName'])) {
            throw new \Exception("First name and last name are required");
        }

        $email =  $request->request->get('email', '');
        $phoneNumber = $request->request->get('mobileNumber', '');
        $address = new Address();

        $address->setEmailAddress($email);
        $address->setPhoneNumber($phoneNumber);
        $address->setCreatedAt(new \DateTimeImmutable());
        $address->setModifiedAt(new \DateTimeImmutable());

        $this->entityManager->persist($address);

        $guardian = new Guardian();
        $guardian->setTitle($data['title'] ?? null);
        $guardian->setFirstName($data['firstName']);
        $guardian->setMiddleName($data['middleName'] ?? null);
        $guardian->setLastName($data['lastName']);

        if (!empty($data['sex'])) {
            $gender = $this->gendersRepository->find($data['sex']);
            $guardian->setGender($gender);
        }


        $guardian->setAddress($address);

        $now = new \DateTimeImmutable();
        $guardian->setCreatedAt($now);
        $guardian->setModifiedAt($now);

        $this->entityManager->persist($guardian);

        $relation = new StudentGuardianRelation();
        $relation->setStudent($student);
        $relation->setGuardian($guardian);

        if (!empty($data['relationship'])) {
            $relationshipType = $this->relationshipTypesRepository->find($data['relationship']);
            $relation->setRelationshipType($relationshipType);
        }

        $isPrimary = isset($data['primaryGuardian']);

        $isPrimary = isset($data['primaryGuardian']);

if ($isPrimary) {

    $existingPrimary = $this->entityManager
        ->getRepository(StudentGuardianRelation::class)
        ->findOneBy([
            'student' => $student,
            'primaryRelation' => true
        ]);

    if ($existingPrimary) {
        throw new \Exception("This student already has a primary guardian. Please remove or update existing primary guardian first.");
    }
}

        $relation->setPrimaryRelation($isPrimary);

        $this->entityManager->persist($relation);

        $this->entityManager->flush();

        return $guardian;
    }
}
