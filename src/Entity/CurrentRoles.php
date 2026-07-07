<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Staffs;
use App\Repository\CurrentRolesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrentRolesRepository::class)]
class CurrentRoles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $currentRole_id = null;

    #[ORM\ManyToOne(inversedBy: 'currentRoles')]
    #[ORM\JoinColumn(name: 'business_role_id', referencedColumnName: 'role_id')]
    private ?BusinessRoles $businessRole = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(nullable: true, type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modified_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    #[ORM\ManyToOne(targetEntity: Staffs::class, inversedBy: 'currentRoles')]
    #[ORM\JoinColumn(name: 'staff_id', referencedColumnName: 'staff_id', nullable: false)]
    private ?Staffs $staff = null;

    public function getCurrentRoleId(): ?int
    {
        return $this->currentRole_id;
    }

    public function getBusinessRole(): ?BusinessRoles
    {
        return $this->businessRole;
    }

    public function setBusinessRole(?BusinessRoles $businessRole): static
    {
        $this->businessRole = $businessRole;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

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
    public function getStaff(): ?Staffs
    {
        return $this->staff;
    }

    public function setStaff(?Staffs $staff): static
    {
        $this->staff = $staff;

        return $this;
    }
}
