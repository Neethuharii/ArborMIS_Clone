<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\StudentEnrollmentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentEnrollmentsRepository::class)]
class StudentEnrollments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $student_enrollment_id = null;


    #[ORM\ManyToOne(inversedBy: 'studentEnrollments')]
    #[ORM\JoinColumn(
        name: 'student_id',
        referencedColumnName: 'student_id',
        nullable: false
    )]
    private ?Students $student = null;


    #[ORM\ManyToOne(inversedBy: 'studentEnrollments')]
    #[ORM\JoinColumn(
        name: 'academic_year_id',
        referencedColumnName: 'academicyear_id',
        nullable: false
    )]
    private ?Academicyears $academicYear = null;

    #[ORM\ManyToOne(inversedBy: 'studentEnrollments')]
    #[ORM\JoinColumn(name: 'classroom_id', referencedColumnName: 'classroom_id', nullable: false)]
    private ?Classrooms $classroom = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;


    public function getStudentEnrollmentId(): ?int
    {
        return $this->student_enrollment_id;
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


    public function getAcademicYear(): ?Academicyears
    {
        return $this->academicYear;
    }


    public function setAcademicYear(?Academicyears $academicYear): static
    {
        $this->academicYear = $academicYear;

        return $this;
    }

    public function getClassroom(): ?Classrooms
    {
        return $this->classroom;
    }

    public function setClassroom(?Classrooms $classroom): static
    {
        $this->classroom = $classroom;

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