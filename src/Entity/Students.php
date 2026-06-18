<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StudentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentsRepository::class)]
class Students
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $studentId = null;

    #[ORM\Column(length: 150)]
    private ?string $firstName = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $middleName = null;

    #[ORM\Column(length: 150)]
    private ?string $lastName = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'gender_id', referencedColumnName: 'gender_id', nullable: false)]
    private ?Genders $gender = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dob = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'ethnicity_id', referencedColumnName: 'ethnicity_id', nullable: true)]
    private ?Ethnicities $ethnicity = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'nationality_id', referencedColumnName: 'nationality_id', nullable: true)]
    private ?Nationality $nationality = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'religion_id', referencedColumnName: 'religion_id', nullable: true)]
    private ?Religions $religion = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'document_id', referencedColumnName: 'document_id', nullable: true)]
    private ?Documents $document = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'country_id', referencedColumnName: 'country_id', nullable: true)]
    private ?Countries $country = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'address_id', referencedColumnName: 'address_id', nullable: false)]
    private ?Address $address = null;

    #[ORM\Column(length: 100, unique: true, nullable: true)]
    private ?string $upn = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'card_id', referencedColumnName: 'card_id', nullable: true)]
    private ?Cards $card = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    /**
     * @var Collection<int, SuspensionDetails>
     */
    #[ORM\OneToMany(targetEntity: SuspensionDetails::class, mappedBy: 'student')]
    private Collection $suspensionDetails;

    /**
     * @var Collection<int, StudentEnrollments>
     */
    #[ORM\OneToMany(targetEntity: StudentEnrollments::class, mappedBy: 'student')]
    private Collection $studentEnrollments;

    public function __construct()
    {
        $this->suspensionDetails = new ArrayCollection();
        $this->studentEnrollments = new ArrayCollection();
    }

    public function getStudentId(): ?int
    {
        return $this->studentId;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    public function setMiddleName(?string $middleName): static
    {
        $this->middleName = $middleName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGender(): ?Genders
    {
        return $this->gender;
    }

    public function setGender(?Genders $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getDob(): ?\DateTimeImmutable
    {
        return $this->dob;
    }

    public function setDob(\DateTimeImmutable $dob): static
    {
        $this->dob = $dob;

        return $this;
    }

    public function getEthnicity(): ?Ethnicities
    {
        return $this->ethnicity;
    }

    public function setEthnicity(?Ethnicities $ethnicity): static
    {
        $this->ethnicity = $ethnicity;

        return $this;
    }

    public function getNationality(): ?Nationality
    {
        return $this->nationality;
    }

    public function setNationality(?Nationality $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getReligion(): ?Religions
    {
        return $this->religion;
    }

    public function setReligion(?Religions $religion): static
    {
        $this->religion = $religion;

        return $this;
    }

    public function getDocument(): ?Documents
    {
        return $this->document;
    }

    public function setDocument(?Documents $document): static
    {
        $this->document = $document;

        return $this;
    }

    public function getCountry(): ?Countries
    {
        return $this->country;
    }

    public function setCountry(?Countries $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getUpn(): ?string
    {
        return $this->upn;
    }

    public function setUpn(?string $upn): static
    {
        $this->upn = $upn;

        return $this;
    }

    public function getCard(): ?Cards
    {
        return $this->card;
    }

    public function setCard(?Cards $card): static
    {
        $this->card = $card;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeImmutable $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection<int, SuspensionDetails>
     */
    public function getSuspensionDetails(): Collection
    {
        return $this->suspensionDetails;
    }

    public function addSuspensionDetail(SuspensionDetails $suspensionDetail): static
    {
        if (!$this->suspensionDetails->contains($suspensionDetail)) {
            $this->suspensionDetails->add($suspensionDetail);
            $suspensionDetail->setStudent($this);
        }

        return $this;
    }

    public function removeSuspensionDetail(SuspensionDetails $suspensionDetail): static
    {
        if ($this->suspensionDetails->removeElement($suspensionDetail)) {
            if ($suspensionDetail->getStudent() === $this) {
                $suspensionDetail->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, StudentEnrollments>
     */
    public function getStudentEnrollments(): Collection
    {
        return $this->studentEnrollments;
    }

    public function addStudentEnrollment(StudentEnrollments $studentEnrollment): static
    {
        if (!$this->studentEnrollments->contains($studentEnrollment)) {
            $this->studentEnrollments->add($studentEnrollment);
            $studentEnrollment->setStudent($this);
        }

        return $this;
    }

    public function removeStudentEnrollment(StudentEnrollments $studentEnrollment): static
    {
        if ($this->studentEnrollments->removeElement($studentEnrollment)) {
            if ($studentEnrollment->getStudent() === $this) {
                $studentEnrollment->setStudent(null);
            }
        }

        return $this;
    }
}
