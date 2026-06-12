<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AttendancesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendancesRepository::class)]
class Attendances
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $attendance_id = null;

    #[ORM\Column]
    private ?int $student_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $attendance_date = null;

    #[ORM\Column(length: 2)]
    private ?string $session = null;

    #[ORM\ManyToOne(inversedBy: 'attendances')]
    #[ORM\JoinColumn(name: "attendance_code_id", referencedColumnName: "attendance_code_id", nullable: false)]
    private ?AttendanceCodes $attendanceCode = null;

    #[ORM\Column(nullable: true)]
    private ?int $late_minutes = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $note = null;

    #[ORM\Column]
    private ?int $marked_by_staff_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $marked_at = null;

    public function getAttendanceId(): ?int
    {
        return $this->attendance_id;
    }

    public function getStudentId(): ?int
    {
        return $this->student_id;
    }

    public function setStudentId(int $student_id): static
    {
        $this->student_id = $student_id;

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

    public function getAttendanceCode(): ?AttendanceCodes
    {
        return $this->attendanceCode;
    }

    public function setAttendanceCode(?AttendanceCodes $attendanceCode): static
    {
        $this->attendanceCode = $attendanceCode;

        return $this;
    }

    public function getLateMinutes(): ?int
    {
        return $this->late_minutes;
    }

    public function setLateMinutes(?int $late_minutes): static
    {
        $this->late_minutes = $late_minutes;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getMarkedByStaffId(): ?int
    {
        return $this->marked_by_staff_id;
    }

    public function setMarkedByStaffId(int $marked_by_staff_id): static
    {
        $this->marked_by_staff_id = $marked_by_staff_id;

        return $this;
    }

    public function getMarkedAt(): ?\DateTimeImmutable
    {
        return $this->marked_at;
    }

    public function setMarkedAt(\DateTimeImmutable $marked_at): static
    {
        $this->marked_at = $marked_at;
        return $this;
    }
}
