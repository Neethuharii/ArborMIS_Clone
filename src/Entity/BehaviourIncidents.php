<?php

namespace App\Entity;

use App\Repository\BehaviourIncidentsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BehaviourIncidentsRepository::class)]
class BehaviourIncidents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'incident_id')]
    private ?int $incidentId = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $incidentDate = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $incidentTime = null;

    /**
     * @var Collection<int, Students>
     */
    #[ORM\ManyToMany(targetEntity: Students::class, inversedBy: 'behaviourIncidents')]
    #[ORM\JoinTable(name: 'behaviour_incidents_students')]
    #[ORM\JoinColumn(name: 'incident_id', referencedColumnName: 'incident_id')]
    #[ORM\InverseJoinColumn(name: 'student_id', referencedColumnName: 'student_id')]
    private Collection $studentInvolved;

    #[ORM\ManyToOne(inversedBy: 'behaviourIncidents')]
    #[ORM\JoinColumn(name:'behaviour_id', referencedColumnName:'behaviour_id', nullable: false)]
    private ?Behaviours $behaviour = null;

    #[ORM\ManyToOne(inversedBy: 'behaviourIncidents')]
    #[ORM\JoinColumn(name:'assigned_staff_id',referencedColumnName:'staff_id',nullable: false)]
    private ?Staffs $assignedStaff = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $incidentSummary = null;

    /**
     * @var Collection<int, Staffs>
     */
    #[ORM\ManyToMany(targetEntity: Staffs::class, inversedBy: 'staffInvolvedIncidents')]
    #[ORM\JoinTable(name:'behaviour_incidents_staffs')]
    #[ORM\JoinColumn(name:'incident_id', referencedColumnName: 'incident_id')]
    #[ORM\InverseJoinColumn(name: 'staff_id', referencedColumnName: 'staff_id')]
    private Collection $staffInvolved;

    #[ORM\ManyToOne(inversedBy: 'behaviourIncidents')]
    #[ORM\JoinColumn(name:'room_id', referencedColumnName:'classroom_id')]
    private ?Classrooms $room = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column( nullable: true)]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    /**
     * @var Collection<int, InterventionDetail>
     */
    #[ORM\OneToMany(targetEntity: InterventionDetail::class, mappedBy: 'behaviourIncident')]
    private Collection $interventionDetails;

    public function __construct()
    {
        $this->studentInvolved = new ArrayCollection();
        $this->staffInvolved = new ArrayCollection();
        $this->interventionDetails = new ArrayCollection();
    }

    public function getIncidentId(): ?int
    {
        return $this->incidentId;
    }

    public function getIncidentDate(): ?\DateTimeInterface
    {
        return $this->incidentDate;
    }

    public function setIncidentDate(\DateTimeInterface $incidentDate): static
    {
        $this->incidentDate = $incidentDate;

        return $this;
    }

    public function getIncidentTime(): ?\DateTimeInterface
    {
        return $this->incidentTime;
    }

    public function setIncidentTime(\DateTimeInterface $incidentTime): static
    {
        $this->incidentTime = $incidentTime;

        return $this;
    }

    /**
     * @return Collection<int, Students>
     */
    public function getStudentInvolved(): Collection
    {
        return $this->studentInvolved;
    }

    public function addStudentInvolved(Students $studentInvolved): static
    {
        if (!$this->studentInvolved->contains($studentInvolved)) {
            $this->studentInvolved->add($studentInvolved);
        }

        return $this;
    }

    public function removeStudentInvolved(Students $studentInvolved): static
    {
        $this->studentInvolved->removeElement($studentInvolved);

        return $this;
    }

    public function getBehaviour(): ?Behaviours
    {
        return $this->behaviour;
    }

    public function setBehaviour(?Behaviours $behaviour): static
    {
        $this->behaviour = $behaviour;

        return $this;
    }

    public function getAssignedStaff(): ?Staffs
    {
        return $this->assignedStaff;
    }

    public function setAssignedStaff(?Staffs $assignedStaff): static
    {
        $this->assignedStaff = $assignedStaff;

        return $this;
    }

    public function getIncidentSummary(): ?string
    {
        return $this->incidentSummary;
    }

    public function setIncidentSummary(?string $incidentSummary): static
    {
        $this->incidentSummary = $incidentSummary;

        return $this;
    }

    /**
     * @return Collection<int, Staffs>
     */
    public function getStaffInvolved(): Collection
    {
        return $this->staffInvolved;
    }

    public function addStaffInvolved(Staffs $staffInvolved): static
    {
        if (!$this->staffInvolved->contains($staffInvolved)) {
            $this->staffInvolved->add($staffInvolved);
        }

        return $this;
    }

    public function removeStaffInvolved(Staffs $staffInvolved): static
    {
        $this->staffInvolved->removeElement($staffInvolved);

        return $this;
    }

    public function getRoom(): ?Classrooms
    {
        return $this->room;
    }

    public function setRoom(?Classrooms $room): static
    {
        $this->room = $room;

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

    public function setDeletedAt(\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

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
            $interventionDetail->setBehaviourIncident($this);
        }

        return $this;
    }

    public function removeInterventionDetail(InterventionDetail $interventionDetail): static
    {
        if ($this->interventionDetails->removeElement($interventionDetail)) {
            if ($interventionDetail->getBehaviourIncident() === $this) {
                $interventionDetail->setBehaviourIncident(null);
            }
        }

        return $this;
    }
}
