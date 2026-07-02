<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StaffsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: StaffsRepository::class)]
class Staffs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'staff_id')]
    private ?int $staffId = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $middleName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'title_id', referencedColumnName: 'title_id')]
    private ?Titles $title = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'gender_id', referencedColumnName: 'gender_id')]
    private ?Genders $gender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $abbreviation = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateOfBirth = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateOfJoining = null;

    #[ORM\Column(nullable: true)]
    private ?int $staffNumber = null;

    #[ORM\ManyToOne(targetEntity: Address::class)]
    #[ORM\JoinColumn(name: 'address_id', referencedColumnName: 'address_id', nullable: true)]
    private ?Address $address = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'ethnicity_id', referencedColumnName: 'ethnicity_id', nullable: true)]
    private ?Ethnicities $ethnicity = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'religion_id', referencedColumnName: 'religion_id', nullable: true)]
    private ?Religions $religion = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'nationality_id', referencedColumnName: 'nationality_id', nullable: true)]
    private ?Nationality $nationality = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'country_id', referencedColumnName: 'country_id', nullable: true)]
    private ?Countries $country = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'card_id', referencedColumnName: 'card_id', nullable: true)]
    private ?Cards $idCard = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'document_id', referencedColumnName: 'document_id', nullable: true)]
    private ?Documents $identityDocument = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profilePhoto = null;

    #[ORM\ManyToOne(targetEntity: CurrentRoles::class)]
    #[ORM\JoinColumn(name: 'role_id', referencedColumnName: 'current_role_id', nullable: true)]
    private ?CurrentRoles $currentRole = null;

    #[ORM\OneToMany(mappedBy: 'staff', targetEntity: Classrooms::class)]
    private Collection $classrooms;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    /**
     * @var Collection<int, BehaviourIncidents>
     */
    #[ORM\OneToMany(targetEntity: BehaviourIncidents::class, mappedBy: 'assignedStaff')]
    private Collection $behaviourIncidents;

    /**
     * @var Collection<int, BehaviourIncidents>
     */
    #[ORM\ManyToMany(targetEntity: BehaviourIncidents::class, mappedBy: 'staffInvolved')]
    private Collection $staffInvolvedIncidents;

    /**
     * @var Collection<int, InterventionDetail>
     */
    #[ORM\OneToMany(targetEntity: InterventionDetail::class, mappedBy: 'staffId')]
    private Collection $interventionDetails;

    /**
     * @var Collection<int, AttendanceRegisters>
     */
    #[ORM\OneToMany(targetEntity: AttendanceRegisters::class, mappedBy: 'staff')]
    private Collection $attendanceRegisters;

    public function __construct()
    {
        $this->behaviourIncidents = new ArrayCollection();
        $this->staffInvolvedIncidents = new ArrayCollection();
        $this->classrooms = new ArrayCollection();
        $this->interventionDetails = new ArrayCollection();
        $this->attendanceRegisters = new ArrayCollection();
    }

    public function getStaffId(): ?int
    {
        return $this->staffId;
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

    public function getTitle(): ?Titles
    {
        return $this->title;
    }

    public function setTitle(?Titles $title): static
    {
        $this->title = $title;

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

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(?string $abbreviation): static
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeImmutable
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeImmutable $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getDateOfJoining(): ?\DateTimeImmutable
    {
        return $this->dateOfJoining;
    }

    public function setDateOfJoining(?\DateTimeImmutable $dateOfJoining): static
    {
        $this->dateOfJoining = $dateOfJoining;

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

    public function getEthnicity(): ?Ethnicities
    {
        return $this->ethnicity;
    }

    public function setEthnicity(?Ethnicities $ethnicity): static
    {
        $this->ethnicity = $ethnicity;

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

    public function getNationality(): ?Nationality
    {
        return $this->nationality;
    }

    public function setNationality(?Nationality $nationality): static
    {
        $this->nationality = $nationality;

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

    public function getIdCard(): ?Cards
    {
        return $this->idCard;
    }

    public function setIdCard(?Cards $idCard): static{

        $this->idCard = $idCard;

        return $this;
    }

    public function getCurrentRole(): ?CurrentRoles
    {
        return $this->currentRole;
    }

    public function setCurrentRole(?CurrentRoles $currentRole): static
    {
        $this->currentRole = $currentRole;

        return $this;
    }

    public function getStaffNumber(): ?int
    {
        return $this->staffNumber;
    }

    public function setStaffNumber(?int $staffNumber): static
    {
        $this->staffNumber = $staffNumber;

        return $this;
    }

    public function getIdentityDocument(): ?Documents
    {
        return $this->identityDocument;
    }

    public function setIdentityDocument(?Documents $identityDocument): static
    {
        $this->identityDocument = $identityDocument;

        return $this;
    }

    public function getProfilePhoto(): ?string
    {
        return $this->profilePhoto;
    }

    public function setProfilePhoto(?string $profilePhoto): static
    {
        $this->profilePhoto = $profilePhoto;

        return $this;
    }

    public function getClassrooms(): Collection
    {
        return $this->classrooms;
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

    public function setModifiedAt(?\DateTimeImmutable $modifiedAt): static
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
     * @return Collection<int, BehaviourIncidents>
     */
    public function getBehaviourIncidents(): Collection
    {
        return $this->behaviourIncidents;
    }

    public function addBehaviourIncident(BehaviourIncidents $behaviourIncident): static
    {
        if (!$this->behaviourIncidents->contains($behaviourIncident)) {
            $this->behaviourIncidents->add($behaviourIncident);
            $behaviourIncident->setAssignedStaff($this);
        }

        return $this;
    }

    public function removeBehaviourIncident(BehaviourIncidents $behaviourIncident): static
    {
        if ($this->behaviourIncidents->removeElement($behaviourIncident)) {
            if ($behaviourIncident->getAssignedStaff() === $this) {
                $behaviourIncident->setAssignedStaff(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BehaviourIncidents>
     */
    public function getStaffInvolvedIncidents(): Collection
    {
        return $this->staffInvolvedIncidents;
    }

    public function addStaffInvolvedIncident(BehaviourIncidents $staffInvolvedIncident): static
    {
        if (!$this->staffInvolvedIncidents->contains($staffInvolvedIncident)) {
            $this->staffInvolvedIncidents->add($staffInvolvedIncident);
            $staffInvolvedIncident->addStaffInvolved($this);
        }

        return $this;
    }

    public function removeStaffInvolvedIncident(BehaviourIncidents $staffInvolvedIncident): static
    {
        if ($this->staffInvolvedIncidents->removeElement($staffInvolvedIncident)) {
            $staffInvolvedIncident->removeStaffInvolved($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, InterventionDetail>
     */
    public function getInterventionDetails(): Collection
    {
        return $this->interventionDetails;
    }

    public function addInterventionDetail(InterventionDetail $interventionDetail): static
    {
        if (!$this->interventionDetails->contains($interventionDetail)) {
            $this->interventionDetails->add($interventionDetail);
            $interventionDetail->setStaff($this);
        }

        return $this;
    }

    public function removeInterventionDetail(InterventionDetail $interventionDetail): static
    {
        if ($this->interventionDetails->removeElement($interventionDetail)) {
            if ($interventionDetail->getStaff() === $this) {
                $interventionDetail->setStaff(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AttendanceRegisters>
     */
    public function getAttendanceRegisters(): Collection
    {
        return $this->attendanceRegisters;
    }

    public function addAttendanceRegister(AttendanceRegisters $attendanceRegister): static
    {
        if (!$this->attendanceRegisters->contains($attendanceRegister)) {
            $this->attendanceRegisters->add($attendanceRegister);
            $attendanceRegister->setStaff($this);
        }

        return $this;
    }

    public function removeAttendanceRegister(AttendanceRegisters $attendanceRegister): static
    {
        if ($this->attendanceRegisters->removeElement($attendanceRegister)) {
            if ($attendanceRegister->getStaff() === $this) {
                $attendanceRegister->setStaff(null);
            }
        }

        return $this;
    }
}

