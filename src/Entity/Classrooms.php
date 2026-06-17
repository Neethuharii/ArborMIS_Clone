<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ClassroomsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClassroomsRepository::class)]
class Classrooms
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $classroom_id = null;

    #[ORM\Column(length: 50)]
    private ?string $class_name = null;

    #[ORM\Column]
    private ?int $staff_id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(
        name: 'academic_year_id',
        referencedColumnName: 'academicyear_id',
        nullable: false
    )]
    private ?Academicyears $academicYear = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getClassroomId(): ?int
    {
        return $this->classroom_id;
    }

    public function getClassName(): ?string
    {
        return $this->class_name;
    }

    public function setClassName(string $class_name): static
    {
        $this->class_name = $class_name;

        return $this;
    }

    public function getStaffId(): ?int
    {
        return $this->staff_id;
    }

    public function setStaffId(int $staff_id): static
    {
        $this->staff_id = $staff_id;

        return $this;
    }

    public function getAcademicYear(): ?Academicyears
    {
        return $this->academicYear;
    }

    public function setAcademicYear(?Academicyears $academicYear): static
    {
        $this->academicYear = $academicYear;

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
}