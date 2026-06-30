<?php

namespace App\Entity;

use App\Repository\AttendanceRegistersRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendanceRegistersRepository::class)]
class AttendanceRegisters
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'attendance_register_id')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'attendanceRegisters')]
    #[ORM\JoinColumn(name:'classroom_id',referencedColumnName: 'classroom_id', nullable: false)]
    private ?Classrooms $classroom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $attendance_date = null;

    #[ORM\Column(length: 2)]
    private ?string $session = null;

    #[ORM\Column(name: 'opened_at')]
    private ?\DateTimeImmutable $openedAt = null;

    #[ORM\ManyToOne(inversedBy: 'attendanceRegisters')]
    #[ORM\JoinColumn(name: 'staff_id',referencedColumnName: 'staff_id', nullable: false)]
    private ?Staffs $staff = null;

    #[ORM\Column(name: 'completed_at', nullable: true)]
    private ?\DateTimeImmutable $completedAt = null;

    public function getattendanceRegisterId(): ?int
    {
        return $this->id;
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

    public function getAttendanceDate(): ?\DateTime
    {
        return $this->attendance_date;
    }

    public function setAttendanceDate(\DateTime $attendance_date): static
    {
        $this->attendance_date = $attendance_date;

        return $this;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(string $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function getOpenedAt(): ?\DateTimeImmutable
    {
        return $this->openedAt;
    }

    public function setOpenedAt(\DateTimeImmutable $openedAt): static
    {
        $this->openedAt = $openedAt;

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

    public function getCompletedAt(): ?\DateTimeImmutable
    {
        return $this->completedAt;
    }

    public function setCompletedAt(?\DateTimeImmutable $completedAt): static
    {
        $this->completedAt = $completedAt;

        return $this;
    }
}
