<?php

namespace App\Entity;

use App\Repository\InterventionDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionDetailRepository::class)]
class InterventionDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'intervention_detail_id')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'interventionDetails')]
    #[ORM\JoinColumn(name:'behaviour_incident_id', referencedColumnName:'incident_id', nullable:false)]
    private ?BehaviourIncidents $behaviourIncident = null;

    #[ORM\ManyToOne(inversedBy: 'interventionDetails')]
    #[ORM\JoinColumn(name:'staff_id', referencedColumnName:'staff_id', nullable:true)]
    private ?Staffs $staff = null;

    #[ORM\ManyToOne(inversedBy: 'interventionDetails')]
    #[ORM\JoinColumn(name:'intervention_id', referencedColumnName:'intervention_id', nullable:true)]
    private ?Interventions $intervention = null;

    #[ORM\ManyToOne(inversedBy: 'interventionDetails')]
    #[ORM\JoinColumn(name:'student_id',referencedColumnName:'student_id', nullable:true)]
    private ?Students $student = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBehaviourIncident(): ?BehaviourIncidents
    {
        return $this->behaviourIncident;
    }

    public function setBehaviourIncident(?BehaviourIncidents $behaviourIncident): static
    {
        $this->behaviourIncident = $behaviourIncident;

        return $this;
    }

    public function getStaff(): ?Staffs
    {
        return $this->staff;
    }

    public function setStaff(?Staffs $staff): static
    {
        $this->staff = $staff;

        return $this;
    }

    public function getIntervention(): ?Interventions
    {
        return $this->intervention;
    }

    public function setIntervention(?Interventions $intervention): static
    {
        $this->intervention = $intervention;

        return $this;
    }

    public function getStudent(): ?Students
    {
        return $this->student;
    }

    public function setStudent(?Students $student): static
    {
        $this->student = $student;

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
}
