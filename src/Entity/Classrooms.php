<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ClassroomsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\ManyToOne(targetEntity: Staffs::class, inversedBy: 'classrooms')]
    #[ORM\JoinColumn(name: 'staff_id', referencedColumnName: 'staff_id', nullable: true)]
    private ?Staffs $staff = null;
 
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(
        name: 'academic_year_id',
        referencedColumnName: 'academicyear_id',
        nullable: false
    )]
    private ?Academicyears $academicYear = null;

    #[ORM\OneToMany(
        targetEntity: StudentEnrollments::class,
        mappedBy: 'classroom'
    )]
    private Collection $studentEnrollments;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, BehaviourIncidents>
     */
    #[ORM\OneToMany(targetEntity: BehaviourIncidents::class, mappedBy: 'room')]
    private Collection $behaviourIncidents;

    public function __construct()
    {
        $this->studentEnrollments = new ArrayCollection();
        $this->behaviourIncidents = new ArrayCollection();
    }

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

    public function getStaff(): ?Staffs
    {
        return $this->staff;
    }

    public function setStaff(Staffs $staff): static
    {
        $this->staff = $staff;

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
            $studentEnrollment->setClassroom($this);
        }

        return $this;
    }

    public function removeStudentEnrollment(StudentEnrollments $studentEnrollment): static
    {
        if ($this->studentEnrollments->removeElement($studentEnrollment)) {
            if ($studentEnrollment->getClassroom() === $this) {
                $studentEnrollment->setClassroom(null);
            }
        }

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
     * @return Collection<int, BehaviourIncidents>
     */
    public function getBehaviourIncidents(): Collection
    {
        return $this->behaviourIncidents;
    }

    public function addBehaviourIncident(BehaviourIncidents $behaviourIncident): static
    {
        if (!$this->behaviourIncidents->contains($behaviourIncident)) {
            $this->behaviourIncidents->add($behaviourIncident);
            $behaviourIncident->setRoom($this);
        }

        return $this;
    }

    public function removeBehaviourIncident(BehaviourIncidents $behaviourIncident): static
    {
        if ($this->behaviourIncidents->removeElement($behaviourIncident)) {
            if ($behaviourIncident->getRoom() === $this) {
                $behaviourIncident->setRoom(null);
            }
        }

        return $this;
    }
}
