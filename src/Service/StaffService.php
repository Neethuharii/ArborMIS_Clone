<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Address;
use App\Entity\Staffs;
use App\Entity\CurrentRoles;
use App\Entity\Documents;
use App\Entity\Cards;
use App\Service\CacheKeys;
use App\Repository\GendersRepository;
use App\Repository\TitlesRepository;
use App\Repository\BusinessRolesRepository;
use App\Repository\EthnicitiesRepository;
use App\Repository\ReligionsRepository;
use App\Repository\DocumentTypesRepository;
use App\Repository\NationalityRepository;
use App\Repository\CountriesRepository;
use App\Repository\StaffsRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use InvalidArgumentException;
use Exception;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class StaffService
{
    public function __construct(
        private StaffsRepository $staffsRepository,
        private GendersRepository $gendersRepository,
        private TitlesRepository $titlesRepository,
        private BusinessRolesRepository $businessRolesRepository,
        private EntityManagerInterface $entityManager,
        private EthnicitiesRepository $ethnicitiesRepository,
        private ReligionsRepository $religionsRepository,
        private DocumentTypesRepository $documentTypesRepository,
        private NationalityRepository $nationalityRepository,
        private CountriesRepository $countriesRepository,
        private CacheInterface $cache
    ) {}

    public function getAllGenders(): array
    {
        return $this->cache->get(CacheKeys::GENDERS, function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->gendersRepository->findAll();
        });
    }

    public function getAllTitles(): array
    {
        return $this->cache->get(CacheKeys::TITLES, function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->titlesRepository->findAll();
        });
    }

    public function getAllBusinessRoles(): array
    {
        return $this->cache->get(CacheKeys::BUSINESS_ROLES, function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->businessRolesRepository->findAll();
        });
    }

    public function getAllStaffs(): array
    {
        return $this->cache->get(CacheKeys::STAFFS, function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->staffsRepository->findAll();
        });  
    }

    public function getAllEthnicities(): array
    {
        return $this->cache->get(CacheKeys::ETHNICITIES, function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->ethnicitiesRepository->findAll();
        });
    }

    public function getAllReligions(): array
    {
        return $this->cache->get(CacheKeys::RELIGIONS, function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->religionsRepository->findAll();
        });
    }

    public function getAllNationalities(): array
    {
        return $this->cache->get(CacheKeys::NATIONALITIES, function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->nationalityRepository->findAll();
        });
    }

    public function getAllDocumentTypes(): array
    {
        return $this->cache->get(CacheKeys::DOCUMENT_TYPES, function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->documentTypesRepository->findAll();
        });
    }

    public function getAllCountries(): array
    {
        return $this->cache->get(CacheKeys::COUNTRIES, function (ItemInterface $item) {
            $item->expiresAfter(3600);
            return $this->countriesRepository->findAll();
        });
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

        try {
            $staff->setDateOfBirth(new DateTimeImmutable($dateofBirth));
        } catch (Exception) {
            return [
                'success' => false,
                'errors' => ['dateofBirth' => 'Invalid date format.'],
            ];
        }

        $staff->setAddress($address);
        $staff->setCreatedAt(new DateTimeImmutable());
        $staff->setModifiedAt(new DateTimeImmutable());
        $this->entityManager->persist($staff);

        $address->setEmailAddress($email);
        $address->setPhoneNumber($phoneNumber);
        $address->setCreatedAt(new DateTimeImmutable());
        $address->setModifiedAt(new DateTimeImmutable());

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
        $roleHistory->setStartDate(new DateTimeImmutable());
        $roleHistory->setCreatedAt(new DateTimeImmutable());
        $roleHistory->setModifiedAt(new DateTimeImmutable());
        $this->entityManager->persist($roleHistory);

        $staff->setCurrentRole($roleHistory);
        $this->entityManager->flush();

        return [
            'success' => true,
            'errors' => [],
        ];
    }

    public function updateStaff(Staffs $staff, Request $request): void
    {
        $firstName = $request->request->get('firstName');
        if ($firstName !== null) {
            $staff->setFirstName($firstName);
        }

        $middleName = $request->request->get('middleName');
        if ($middleName !== null) {
            $staff->setMiddleName($middleName);
        }

        $lastName = $request->request->get('lastName');
        if ($lastName !== null) {
            $staff->setLastName($lastName);
        }

        $genderId = $request->request->get('gender');
        if ($genderId) {
            $gender = $this->gendersRepository->find($genderId);
            $staff->setGender($gender);
        }

        $dob = $request->request->get('dob');
        if ($dob !== null) {
            $staff->setDateOfBirth(new DateTimeImmutable($dob));
        }

        $ethnicityId = $request->request->get('ethnicity');
        if ($ethnicityId) {
            $ethnicity = $this->ethnicitiesRepository->find($ethnicityId);
            $staff->setEthnicity($ethnicity);
        }

        $nationalityId = $request->request->get('nationality');
        if ($nationalityId) {
            $nationality = $this->nationalityRepository->find($nationalityId);
            $staff->setNationality($nationality);
        }

        $countryId = $request->request->get('country');
        if ($countryId) {
            $country = $this->countriesRepository->find($countryId);
            $staff->setCountry($country);
        }

        $religionId = $request->request->get('religion');
        if ($religionId) {
            $religion = $this->religionsRepository->find($religionId);
            $staff->setReligion($religion);
        }

        $abbreviation = $request->request->get('abbreviation');
        if ($abbreviation !== null) {
            $staff->setAbbreviation($abbreviation);
        }

        $email = $request->request->get('email');
        if ($email) {
            $address = $staff->getAddress();
            if (!$address) {
                $address = new Address();
            }
            $address->setEmailAddress($email);
            $address->setModifiedAt(new DateTimeImmutable());
            $this->entityManager->persist($address);

            $staff->setAddress($address);
        }
        $staff->setModifiedAt(new DateTimeImmutable());

        $this->entityManager->flush();
    }

    public function updateStaffDocuments(Staffs $staff, Request $request): void
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

            if (!empty($issueDateStr)) {
                $document->setIssueDate(new DateTimeImmutable($issueDateStr));
            }
            if (!empty($expiryDateStr)) {
                $document->setExpiryDate(new DateTimeImmutable($expiryDateStr));
            }

            $document->setModifiedAt(new DateTimeImmutable());
            $this->entityManager->persist($document);

            $staff->setIdentityDocument($document);
            $this->entityManager->flush();
        }
    }

    public function updateStaffCard(Staffs $staff, Request $request): void
    {
        $cardno = $request->request->get('cardNumber');
        if ($cardno) {
            $card = $staff->getIdCard();
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

            $staff->setIdCard($card);
        }
        $staff->setModifiedAt(new DateTimeImmutable());
        $this->entityManager->flush();
    }

    public function updateAddress(Staffs $staff, Request $request): void
    {
        $address = $staff->getAddress();
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
        $city = $request->request->get('city');
        $address->setCity($city);
        $address->setCounty($county);
        $address->setPostCode($postCode);

        $staff->setAddress($address);
        $this->entityManager->persist($address);

        $this->entityManager->flush();
    }

    public function addBusinessRole(Staffs $staff, Request $request): void
    {
        $roleId = (int) $request->request->get('role', 0);
        $startDateStr = $request->request->get('startDate');
        $endDateStr = $request->request->get('endDate');

        if ($roleId === 0) {
            throw new InvalidArgumentException("A valid business role must be selected.");
        }

        $businessRole = $this->businessRolesRepository->find($roleId);
        if (!$businessRole) {
            throw new InvalidArgumentException("The selected business role does not exist.");
        }

        $role = new CurrentRoles();
        $role->setCreatedAt(new DateTimeImmutable());
        $role->setModifiedAt(new DateTimeImmutable());
        $role->setBusinessRole($businessRole);

        $role->setStaff($staff);
        $staff->setCurrentRole($role);

        if (!empty($startDateStr)) {
            $startDate = \DateTimeImmutable::createFromFormat('Y-m-d', $startDateStr);

            if (!$startDate) {
                $startDate = \DateTimeImmutable::createFromFormat('d M Y', $startDateStr);
            }

            $role->setStartDate($startDate ?: new \DateTimeImmutable());
        } else {
            $role->setStartDate(new \DateTimeImmutable());
        }

        if (!empty($endDateStr)) {
            $endDate = \DateTimeImmutable::createFromFormat('Y-m-d', $endDateStr);

            if (!$endDate) {
                $endDate = \DateTimeImmutable::createFromFormat('d M Y', $endDateStr);
            }

            $role->setEndDate($endDate ?: null);
        } else {
            $role->setEndDate(null);
        }

        $staff->setModifiedAt(new DateTimeImmutable());

        $this->entityManager->persist($role);
        $this->entityManager->flush();
    }
}
