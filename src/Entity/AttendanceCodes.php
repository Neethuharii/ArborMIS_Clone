<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AttendanceCodesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendanceCodesRepository::class)]
class AttendanceCodes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
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

    /**
     * @var Collection<int, Attendances>
     */
    #[ORM\OneToMany(targetEntity: Attendances::class, mappedBy: 'attendanceCode')]
    private Collection $attendances;

    public function __construct()
    {
        $this->attendances = new ArrayCollection();
    }

    public function getAttendanceCodeId(): ?int
    {
        return $this->attendance_code_id;
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

    /**
     * @return Collection<int, Attendances>
     */
    public function getAttendances(): Collection
    {
        return $this->attendances;
    }

    public function addAttendance(Attendances $attendance): static
    {
        if (!$this->attendances->contains($attendance)) {
            $this->attendances->add($attendance);
            $attendance->setAttendanceCode($this);
        }

        return $this;
    }

    public function removeAttendance(Attendances $attendance): static
    {
        if ($this->attendances->removeElement($attendance)) {
            
        }

        return $this;
    }
}

