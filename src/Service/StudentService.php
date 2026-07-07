<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Address;
use App\Entity\Cards;
use App\Entity\Documents;
use App\Entity\Fundings;
use App\Entity\Guardian;
use App\Entity\StudentGuardianRelation;
use App\Entity\Students;
use App\Repository\CountriesRepository;
use App\Repository\DocumentTypesRepository;
use App\Repository\EthnicitiesRepository;
use App\Repository\FundingTypesRepository;
use App\Repository\GendersRepository;
use App\Repository\NationalityRepository;
use App\Repository\RelationshipTypesRepository;
use App\Repository\ReligionsRepository;
use App\Repository\StudentsRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

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
        private readonly RelationshipTypesRepository $relationshipTypesRepository,
        private readonly StudentsRepository $studentsRepository,
        private readonly FundingTypesRepository $fundingTypesRepository,
        private readonly CacheInterface $lookupCache,
        private readonly string $profileImageDirectory
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
        $address->setCreatedAt(new DateTimeImmutable());
        $address->setModifiedAt(new DateTimeImmutable());
        $this->entityManager->persist($address);
        $student = new Students();
        $student->setFirstName($firstName);
        $student->setMiddleName($middleName);
        $student->setLastName($lastName);
        $student->setGender($gender);
        $student->setDob(new DateTimeImmutable($dob));
        $student->setAddress($address);
        $student->setCreatedAt(new DateTimeImmutable());
        $student->setModifiedAt(new DateTimeImmutable());

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
        $email = $request->request->get('email');
        if ($email) {
            $address = $student->getAddress();
            if (!$address) {
                $address = new Address();
            }
            $address->setEmailAddress($email);
            $address->setModifiedAt(new \DateTimeImmutable());
            $this->entityManager->persist($address);

            $student->setAddress($address);
        }
        $student->setModifiedAt(new DateTimeImmutable());
        $this->entityManager->flush();
    }

    public function updateStudentDocuments(Students $student, Request $request): void
    {
        $documentTypeId = $request->request->get('documentType');
        $documentNumber = $request->request->get('documentNumber');
        $issueDateStr = $request->request->get('issueDate');
        $expiryDateStr = $request->request->get('expiryDate');


        if ($documentTypeId && $documentNumber) {
            $documentType = $this->documentTypesRepository->find($documentTypeId);

            if (!$documentType) {
                throw new InvalidArgumentException("Invalid document type selected.");
            }

            $document = new Documents();
            $document->setDocumentNumber($documentNumber);
            $document->setDocumentType($documentType);
            $issueDate = new DateTimeImmutable($issueDateStr);
            $document->setIssueDate($issueDate);

            if (!empty($issueDateStr)) {
                $document->setIssueDate(new DateTimeImmutable($issueDateStr));
            }
            if (!empty($expiryDateStr)) {
                $document->setExpiryDate(new DateTimeImmutable($expiryDateStr));
            }

            $document->setModifiedAt(new DateTimeImmutable());
            $this->entityManager->persist($document);

            $student->setDocument($document);
            $this->entityManager->flush();
        }
    }
    public function updateStudentCard(Students $student, Request $request): void
    {
        $cardno = $request->request->get('cardNumber');
        if ($cardno) {
            $card = $student->getCard();
            if (!$card) {
                $card = new Cards();
            }
            $card->setCardNumber($cardno);

            $cardstatus = $request->request->has('status');
            $card->setStatus($cardstatus);

            $issuetime = $request->request->get('issuedTime');
            $issuedate = $request->request->get('issuedDate');
            if ($issuedate && $issuetime) {
                $card->setIssuedAt(
                    new DateTimeImmutable($issuedate . ' ' . $issuetime)
                );
            }

            $card->setModifiedAt(new DateTimeImmutable());
            $this->entityManager->persist($card);

            $student->setCard($card);
        }
        $student->setModifiedAt(new \DateTimeImmutable());
        $this->entityManager->flush();
    }

    public function createGuardianForStudent(array $data, Students $student, Request $request): Guardian
    {
        if (empty($data['firstName']) || empty($data['lastName'])) {
            throw new Exception("First name and last name are required");
        }

        $email =  $request->request->get('email', '');
        $phoneNumber = $request->request->get('mobileNumber', '');
        $address = new Address();

        $address->setEmailAddress($email);
        $address->setPhoneNumber($phoneNumber);
        $address->setCreatedAt(new DateTimeImmutable());
        $address->setModifiedAt(new DateTimeImmutable());

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

        $now = new DateTimeImmutable();
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


        if ($isPrimary) {

            $existingPrimary = $this->entityManager
                ->getRepository(StudentGuardianRelation::class)
                ->findOneBy([
                    'student' => $student,
                    'primaryRelation' => true
                ]);

            if ($existingPrimary) {
                throw new Exception("This student already has a primary guardian. Please remove or update existing primary guardian first.");
            }
        }

        $relation->setPrimaryRelation($isPrimary);

        $this->entityManager->persist($relation);

        $this->entityManager->flush();

        return $guardian;
    }

    public function deleteUpn(Students $student): void
    {
        $student->setUpn(null);

        $student->setModifiedAt(new DateTimeImmutable());

        $this->entityManager->flush();
    }

    public function generateUpn(): string
    {
        do {
            $upn = chr(rand(65, 90)) . str_pad((string) random_int(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $exists = $this->studentsRepository->findOneBy([
                'upn' => $upn
            ]);
        } while ($exists);
        return $upn;
    }

    public function addFunding(Students $student, Request $request): void
    {
        $fundingTypeId = $request->request->get('fundingType');
        $description = $request->request->get('description');

        $fundingType = $this->fundingTypesRepository->find($fundingTypeId);

        if (!$fundingType) {
            throw new Exception('Funding type not found.');
        }

        $funding = new Fundings();

        $funding->setStudent($student);
        $funding->setFundingType($fundingType);
        $funding->setDescription($description);

        $funding->setStartDate(new DateTime());
        $funding->setEndDate(null);

        $funding->setCreatedAt(new DateTimeImmutable());
        $funding->setModifiedAt(new DateTimeImmutable());

        $this->entityManager->persist($funding);
        $this->entityManager->flush();
        $this->clearLookupCache();
    }

    public function updateAddress(Students $student, Request $request): void
    {
        $address = $student->getAddress();
        if (!$address) {
            $address = new Address();
        }
        $line1 = $request->request->get('address1');
        $line2 = $request->request->get('address2', null);
        $line3 = $request->request->get('address3', null);
        $city = $request->request->get('city');
        $county = $request->request->get('county', null);
        $postCode = $request->request->get('postalCode');

        $address->setAddress1($line1);
        $address->setAddress2($line2);
        $address->setAddress3($line3);
        $address->setCity($city);
        $address->setCounty($county);
        $address->setPostCode($postCode);

        $student->setAddress($address);
        $this->entityManager->persist($address);

        $this->entityManager->flush();
        $this->clearLookupCache();
    }

    public function getLookupData(): array
    {
        return $this->lookupCache->get('student_lookup_data', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            return [
                'genders'       => $this->gendersRepository->findAll(),
                'countries'     => $this->countriesRepository->findAll(),
                'ethnicities'   => $this->ethnicitiesRepository->findAll(),
                'nationalities' => $this->nationalityRepository->findAll(),
                'religions'     => $this->religionsRepository->findAll(),
                'relationships' => $this->relationshipTypesRepository->findAll(),
                'documentTypes' => $this->documentTypesRepository->findAll(),
                'fundingTypes'  => $this->fundingTypesRepository->findAll(),
            ];
        });
    }
    public function clearLookupCache(): void
    {
        $this->lookupCache->delete('student_lookup_data');
    }

   public function uploadProfileImage(Students $student, UploadedFile $file): void
{
    $fileName = uniqid() . '.' . $file->guessExtension();

    $file->move(
        $this->profileImageDirectory,
        $fileName
    );

    $student->setProfileImage($fileName);

    $this->entityManager->flush();
}

}
