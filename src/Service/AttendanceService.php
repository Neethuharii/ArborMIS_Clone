<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Attendances;
use App\Entity\Staffs;
use App\Repository\StaffsRepository;
use App\Entity\AttendanceRegisters;
use App\Entity\Classrooms;
use App\Repository\AcademicyearsRepository;
use App\Repository\AttendanceCodesRepository;
use App\Repository\AttendancesRepository;
use App\Repository\AttendanceRegistersRepository;
use App\Repository\StudentEnrollmentsRepository;
use DateTime;
use DateTimeInterface;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

final class AttendanceService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AcademicyearsRepository $academicyearsRepository,
        private readonly AttendanceCodesRepository $attendanceCodesRepository,
        private readonly AttendancesRepository $attendancesRepository,
        private readonly AttendanceRegistersRepository $attendanceRegistersRepository,
        private readonly StudentEnrollmentsRepository $studentEnrollmentsRepository
    ) {}

    public function isAttendanceDay(): bool
    {
        $date = new DateTime();

        return (int) $date->format('N') < 6;
    }


    public function getCurrentAttendanceSession(): string
    {
        $now = new DateTime();

        return ((int) $now->format('G') >= 13)
            ? 'PM'
            : 'AM';
    }

public function getStaffStudents($staff): array
{
    $academicYear = $this->academicyearsRepository->findCurrentAcademicYear();

    if (!$academicYear) {
        return [];
    }

    $session = $this->getCurrentAttendanceSession();
    $today = new DateTime();
    $students = [];

    foreach ($staff->getClassrooms() as $classroom) {

        if (
            !$classroom->getAcademicYear() ||
            $classroom->getAcademicYear()->getAcademicyearId() !== $academicYear->getAcademicyearId()
        ) {
            continue;
        }

        $students = array_merge(
            $students,
            $this->getStudentsForRegister($classroom, $today, $session)
        );
    }

    return $students;
}
    public function getAbsenceCodes(): array
    {
        $academicYear =
            $this->academicyearsRepository
            ->findCurrentAcademicYear();

        if (!$academicYear) {
            return [];
        }

        $codes =
            $this->attendanceCodesRepository
            ->findAbsenceCodes($academicYear);

        return array_map(
            function ($code) {

                return [
                    'id' =>
                    $code->getAttendanceCodeId(),

                    'code' =>
                    $code->getCode(),

                    'description' =>
                    $code->getDescription(),
                ];
            },
            $codes
        );
    }

    public function getLateCodes(): array
    {
        $academicYear =
            $this->academicyearsRepository
            ->findCurrentAcademicYear();

        if (!$academicYear) {
            return [];
        }

        $codes =
            $this->attendanceCodesRepository
            ->findLateCodes($academicYear);

        return array_map(
            function ($code) {

                return [
                    'id' =>
                    $code->getAttendanceCodeId(),

                    'code' =>
                    $code->getCode(),

                    'description' =>
                    $code->getDescription(),
                ];
            },
            $codes
        );
    }

    public function getStudentsForRegister(Classrooms $classroom, DateTime $date, string $session): array
{
    $students = [];

    foreach ($classroom->getStudentEnrollments() as $enrollment) {

        $student = $enrollment->getStudent();

        if (!$student) {
            continue;
        }

        $attendance = $this->attendancesRepository->findAttendance($enrollment, $date, $session);

        $attendanceStatus = 'Not Marked';
        $attendanceClass = '';

        if ($attendance) {
            $attendanceStatus = $attendance->getAttendanceCode()->getCode()
                . ' - ' . $attendance->getAttendanceCode()->getDescription();

            $code = strtoupper($attendance->getAttendanceCode()->getCode());

            $attendanceClass = match (true) {
                $code === '/' || $code === '\\' => 'row-present',
                $code === 'L' => 'row-late',
                default => 'row-absent',
            };
        }

        $students[] = [
            'enrollmentId' => $enrollment->getStudentEnrollmentId(),
            'studentId' => $student->getStudentId(),
            'firstName' => $student->getFirstName(),
            'lastName' => $student->getLastName(),
            'classroom' => $classroom->getClassName(),
            'attendanceStatus' => $attendanceStatus,
            'attendanceClass' => $attendanceClass,
        ];
    }

    return $students;
}

    
    public function getPresentAttendanceCodeId(
        string $session
    ): ?int {

        $academicYear =
            $this->academicyearsRepository
            ->findCurrentAcademicYear();

        if (!$academicYear) {
            return null;
        }

        $attendanceCode =
            $this->attendanceCodesRepository
            ->findPresentCode(
                $academicYear,
                $session
            );

        return $attendanceCode?->getAttendanceCodeId();
    }

    public function saveAttendance(
        int $studentEnrollmentId,
        int $attendanceCodeId,
        string $session,
        int $staffId,
        string $attendanceDateString,
        ?int $lateMinutes = null,
        ?string $note = null
    ): void {

        $enrollment =
            $this->studentEnrollmentsRepository
            ->find($studentEnrollmentId);

        if (!$enrollment) {
            return;
        }

        $attendanceCode =
            $this->attendanceCodesRepository
            ->findCodeById($attendanceCodeId);

        if (!$attendanceCode) {
            return;
        }

        $attendanceDate = new DateTime($attendanceDateString);

        $attendance =
            $this->attendancesRepository
            ->findAttendance(
                $enrollment,
                $attendanceDate,
                $session
            );

        if (!$attendance) {

            $attendance = new Attendances();

            $attendance->setStudentEnrollment(
                $enrollment
            );

            $attendance->setAttendanceDate(
                $attendanceDate
            );

            $attendance->setSession(
                $session
            );

            $attendance->setCreatedAt(
                new DateTimeImmutable()
            );
        }

        $attendance->setAttendanceCode(
            $attendanceCode
        );

        $attendance->setLateMinutes(
            $lateMinutes
        );

        $attendance->setNote(
            $note
        );

        $attendance->setMarkedByStaffId(
            $staffId
        );

        $attendance->setMarkedAt(
            new DateTimeImmutable()
        );

        $attendance->setModifiedAt(
            new DateTimeImmutable()
        );

        $this->entityManager->persist(
            $attendance
        );

        $this->entityManager->flush();

        $this->completeRegisterIfFullyMarked(
            $enrollment->getClassroom(),
            $attendanceDate,
            $session
        );
    }

    public function getRegisterByDate(Staffs $staff, string $selectedDate): array
    {
        $academicYear = $this->academicyearsRepository
            ->findAcademicYearByDate(new DateTimeImmutable($selectedDate));

        if (!$academicYear) {
            return [];
        }

        $date = new DateTime($selectedDate);
        $registers = [];

        foreach ($staff->getClassrooms() as $classroom) {
            if ($classroom->getAcademicYear()->getAcademicyearId() !== $academicYear->getAcademicyearId()) {
                continue;
            }

            foreach (['AM', 'PM'] as $session) {
                $register = $this->attendanceRegistersRepository
                    ->findByClassroomDateSession($classroom, $date, $session);

                $registers[] = [
                    'classroom' => $classroom,
                    'session' => $session,
                    'staff' => $register?->getStaff() ?? $classroom->getStaff(),
                    'opened' => $register?->getOpenedAt(),
                    'completedValid' => $register?->getCompletedAt() !== null,
                    'status' => $register === null
                        ? 'Attendance register not opened yet'
                        : ($register->getCompletedAt() ? 'Attendance register complete' : 'Attendance register opened'),
                    'registerId' => $register?->getattendanceRegisterId(),
                ];
            }
        }

        return $registers;
    }

    public function openRegister(
        Classrooms $classroom,
        DateTimeInterface $date,
        string $session,
        Staffs $staff
    ): AttendanceRegisters {

        $register = $this->attendanceRegistersRepository
            ->findByClassroomDateSession($classroom, $date, $session);

        if ($register) {
            return $register;
        }

        $register = new AttendanceRegisters();
        $register->setClassroom($classroom);
        $register->setAttendanceDate($date);
        $register->setSession($session);
        $register->setStaff($staff);
        $register->setOpenedAt(new DateTimeImmutable());

        $this->entityManager->persist($register);
        $this->entityManager->flush();

        return $register;
    }

    public function completeRegisterIfFullyMarked(
        Classrooms $classroom,
        DateTime $date,
        string $session
    ): void {

        $register = $this->attendanceRegistersRepository
            ->findByClassroomDateSession($classroom, $date, $session);

        if (!$register || $register->isCompleted()) {
            return;
        }

        $totalStudents = count($classroom->getStudentEnrollments());

        $markedCount = $this->attendancesRepository
            ->countMarkedForClassroomDateSession($classroom, $date, $session);

        if ($markedCount >= $totalStudents) {
            $register->setCompletedAt(new DateTimeImmutable());
            $this->entityManager->flush();
        }
    }
}
