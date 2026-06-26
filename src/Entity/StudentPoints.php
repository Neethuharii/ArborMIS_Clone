<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StudentPointsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentPointsRepository::class)]
class StudentPoints
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'student_point_id')]
    private ?int $studentPointId = null;

    #[ORM\OneToOne(inversedBy: 'studentPoints')]
    #[ORM\JoinColumn(name:'student_id', referencedColumnName:'student_id', nullable: false)]
    private ?Students $student = null;

    #[ORM\Column]
    private ?int $totalPoints = 0;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getStudentPointId(): ?int
    {
        return $this->studentPointId;
    }

    public function getStudent(): ?Students
    {
        return $this->student;
    }

    public function setStudent(Students $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getTotalPoints(): ?int
    {
        return $this->totalPoints;
    }

    public function setTotalPoints(int $totalPoints): static
    {
        $this->totalPoints = $totalPoints;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
