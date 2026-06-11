<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\AttendanceCodesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendanceCodesRepository::class)]
class AttendanceCodes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $attendance_code_id = null;

    #[ORM\Column(length: 20)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    private ?string $category = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $effective_from = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $effective_to = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAttendanceCodeId(): ?int
    {
        return $this->attendance_code_id;
    }

    public function setAttendanceCodeId(int $attendance_code_id): static
    {
        $this->attendance_code_id = $attendance_code_id;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getEffectiveFrom(): ?\DateTime
    {
        return $this->effective_from;
    }

    public function setEffectiveFrom(\DateTime $effective_from): static
    {
        $this->effective_from = $effective_from;

        return $this;
    }

    public function getEffectiveTo(): ?\DateTime
    {
        return $this->effective_to;
    }

    public function setEffectiveTo(?\DateTime $effective_to): static
    {
        $this->effective_to = $effective_to;

        return $this;
    }
}
