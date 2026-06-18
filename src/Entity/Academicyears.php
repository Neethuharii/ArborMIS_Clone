<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AcademicyearsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcademicyearsRepository::class)]
class Academicyears
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $academicyear_id = null;

    #[ORM\Column(length: 25)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $start_date = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $end_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;


    #[ORM\OneToMany(
        targetEntity: StudentEnrollments::class,
        mappedBy: 'academicYear'
    )]
    private Collection $studentEnrollments;


    #[ORM\OneToMany(
        targetEntity: Classrooms::class,
        mappedBy: 'academicYear'
    )]
    private Collection $classrooms;


    public function __construct()
    {
        $this->studentEnrollments = new ArrayCollection();
        $this->classrooms = new ArrayCollection();
    }


    public function getAcademicyearId(): ?int
    {
        return $this->academicyear_id;
    }


    public function getName(): ?string
    {
        return $this->name;
    }


    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }


    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->start_date;
    }


    public function setStartDate(\DateTimeImmutable $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }


    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->end_date;
    }


    public function setEndDate(\DateTimeImmutable $end_date): static
    {
        $this->end_date = $end_date;

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


    /**
     * @return Collection<int, StudentEnrollments>
     */
    public function getStudentEnrollments(): Collection
    {
        return $this->studentEnrollments;
    }


    public function addStudentEnrollment(StudentEnrollments $studentEnrollment): static
    {
        if (!$this->studentEnrollments->contains($studentEnrollment)) {
            $this->studentEnrollments->add($studentEnrollment);
            $studentEnrollment->setAcademicYear($this);
        }

        return $this;
    }


    public function removeStudentEnrollment(StudentEnrollments $studentEnrollment): static
    {
        if ($this->studentEnrollments->removeElement($studentEnrollment)) {
            if ($studentEnrollment->getAcademicYear() === $this) {
                $studentEnrollment->setAcademicYear(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection<int, Classrooms>
     */
    public function getClassrooms(): Collection
    {
        return $this->classrooms;
    }


    public function addClassroom(Classrooms $classroom): static
    {
        if (!$this->classrooms->contains($classroom)) {
            $this->classrooms->add($classroom);
            $classroom->setAcademicYear($this);
        }

        return $this;
    }


    public function removeClassroom(Classrooms $classroom): static
    {
        if ($this->classrooms->removeElement($classroom)) {
            if ($classroom->getAcademicYear() === $this) {
                $classroom->setAcademicYear(null);
            }
        }

        return $this;
    }
}
