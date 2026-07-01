<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StudentGuardianRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentGuardianRepository::class)]
class StudentGuardianRelation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $relationId = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'relationship_type_id', referencedColumnName: 'relationship_type_id', nullable: false)]
    private ?RelationshipTypes $relationshipType = null;

    #[ORM\ManyToOne]
   #[ORM\JoinColumn(name: 'student_id', referencedColumnName: 'student_id', nullable: false)]
    private ?Students $student = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'guardian_id', referencedColumnName: 'guardian_id', nullable: false)]
    private ?Guardian $guardian = null;

    #[ORM\Column]
   private bool $primaryRelation = false;

    public function getRelationId(): ?int
    {
        return $this->relationId;
    }

    public function getRelationshipType(): ?RelationshipTypes
    {
        return $this->relationshipType;
    }

    public function setRelationshipType(?RelationshipTypes $relationshipType): static
    {
        $this->relationshipType = $relationshipType;

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

    public function getGuardian(): ?Guardian
    {
        return $this->guardian;
    }

    public function setGuardian(?Guardian $guardian): static
    {
        $this->guardian = $guardian;

        return $this;
    }

    public function isPrimaryRelation(): bool
    {
        return $this->primaryRelation;
    }

    public function setPrimaryRelation(bool $primaryRelation): static
    {
        $this->primaryRelation = $primaryRelation;

        return $this;
    }
}
