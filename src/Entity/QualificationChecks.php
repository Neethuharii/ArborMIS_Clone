<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QualificationChecksRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QualificationChecksRepository::class)]
class QualificationChecks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $qualification_checks_id = null;

    #[ORM\ManyToOne(targetEntity: QualificationType::class, inversedBy: 'qualificationChecks')]
    #[ORM\JoinColumn(name: 'qualification_id', referencedColumnName: 'qualification_id', nullable: false)]
    private ?QualificationType $qualificationType = null;

    #[ORM\Column(length: 255)]
    private ?string $clearance_level = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $requested_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $returned_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $authenticated_date = null;

    #[ORM\ManyToOne(targetEntity: Staffs::class)]
    #[ORM\JoinColumn(name: 'staff_id', referencedColumnName: 'staff_id', nullable: false)]
    private ?Staffs $staff = null;

    #[ORM\ManyToOne(targetEntity: Staffs::class)]
    #[ORM\JoinColumn(name: 'authenticated_by_staff_id', referencedColumnName: 'staff_id', nullable: true)]
    private ?Staffs $authenticatedBy = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modified_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    public function getQualificationChecksId(): ?int
    {
        return $this->qualification_checks_id;
    }

    public function getQualificationType(): ?QualificationType
    {
        return $this->qualificationType;
    }

    public function setQualificationType(?QualificationType $qualificationType): static
    {
        $this->qualificationType = $qualificationType;
        return $this;
    }

    public function getClearanceLevel(): ?string
    {
        return $this->clearance_level;
    }

    public function setClearanceLevel(string $clearance_level): static
    {
        $this->clearance_level = $clearance_level;
        return $this;
    }

    public function getRequestedDate(): ?\DateTime
    {
        return $this->requested_date;
    }

    public function setRequestedDate(\DateTime $requested_date): static
    {
        $this->requested_date = $requested_date;
        return $this;
    }

    public function getReturnedDate(): ?\DateTime
    {
        return $this->returned_date;
    }

    public function setReturnedDate(\DateTime $returned_date): static
    {
        $this->returned_date = $returned_date;
        return $this;
    }

    public function getAuthenticatedDate(): ?\DateTime
    {
        return $this->authenticated_date;
    }

    public function setAuthenticatedDate(?\DateTime $authenticated_date): static
    {
        $this->authenticated_date = $authenticated_date;
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

    public function getAuthenticatedBy(): ?Staffs
    {
        return $this->authenticatedBy;
    }

    public function setAuthenticatedBy(?Staffs $authenticatedBy): static
    {
        $this->authenticatedBy = $authenticatedBy;
        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modified_at;
    }

    public function setModifiedAt(\DateTimeImmutable $modified_at): static
    {
        $this->modified_at = $modified_at;
        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): static
    {
        $this->deleted_at = $deleted_at;
        return $this;
    }
}
