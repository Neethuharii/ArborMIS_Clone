<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Attendances;
use App\Repository\AcademicyearsRepository;
use App\Repository\AttendanceCodesRepository;
use App\Repository\AttendancesRepository;
use App\Repository\StudentEnrollmentsRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

final class AttendanceService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly AcademicyearsRepository $academicyearsRepository,
        private readonly AttendanceCodesRepository $attendanceCodesRepository,
        private readonly AttendancesRepository $attendancesRepository,
        private readonly StudentEnrollmentsRepository $studentEnrollmentsRepository
    ) {}

    public function getAttendanceDates(): array
    {
        $dates = [];

        $academicYear =
            $this->academicyearsRepository
            ->findCurrentAcademicYear();

        if (!$academicYear) {
            return [];
        }

        $startDate = DateTime::createFromImmutable(
            $academicYear->getStartDate()
        );

        $currentDate = new DateTime();
        $today = new DateTime();

        while ($currentDate >= $startDate) {

            $day = (int) $currentDate->format('N');

            if ($day !== 6 && $day !== 7) {

                $formattedDate =
                    $currentDate->format('D, d M Y');

                if (
                    $currentDate->format('Y-m-d')
                    !==
                    $today->format('Y-m-d')
                ) {

                    $dates[] = $formattedDate . ' AM';
                    $dates[] = $formattedDate . ' PM';
                } else {

                    if ((int) $today->format('G') >= 9) {
                        $dates[] = $formattedDate . ' AM';
                    }

                    if ((int) $today->format('G') >= 13) {
                        $dates[] = $formattedDate . ' PM';
                    }
                }
            }

            $currentDate->modify('-1 day');
        }

        return $dates;
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
        $students = [];

        $academicYear =
            $this->academicyearsRepository
            ->findCurrentAcademicYear();

        if (!$academicYear) {
            return [];
        }

        $session = $this->getCurrentAttendanceSession();

        foreach ($staff->getClassrooms() as $classroom) {

            foreach ($classroom->getStudentEnrollments() as $enrollment) {

                $enrollmentAcademicYear =
                    $enrollment->getAcademicYear();

                if (
                    !$enrollmentAcademicYear ||
                    $enrollmentAcademicYear->getAcademicYearId()
                    !==
                    $academicYear->getAcademicYearId()
                ) {
                    continue;
                }

                $student =
                    $enrollment->getStudent();

                if (!$student) {
                    continue;
                }

                $attendance =
                    $this->attendancesRepository
                    ->findAttendance(
                        $enrollment,
                        new DateTime(),
                        $session
                    );

                $attendanceStatus = 'Not Marked';
                $attendanceClass = '';

                if ($attendance) {

                    $attendanceStatus =
                        $attendance->getAttendanceCode()->getCode()
                        . ' - '
                        . $attendance->getAttendanceCode()->getDescription();

                    $code =
                        strtoupper(
                            $attendance
                                ->getAttendanceCode()
                                ->getCode()
                        );

                    if ($code === 'P') {
                        $attendanceClass = 'row-present';
                    } elseif (
                        $code === 'L' ||
                        $code === 'LT'
                    ) {
                        $attendanceClass = 'row-late';
                    } else {
                        $attendanceClass = 'row-absent';
                    }
                }

                $students[] = [
                    'enrollmentId' =>
                    $enrollment->getStudentEnrollmentId(),

                    'studentId' =>
                    $student->getStudentId(),

                    'firstName' =>
                    $student->getFirstName(),

                    'lastName' =>
                    $student->getLastName(),

                    'classroom' =>
                    $classroom->getClassName(),

                    'attendanceStatus' =>
                    $attendanceStatus,

                    'attendanceClass' =>
                    $attendanceClass,
                ];
            }
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

        $today = new DateTime();

        $attendance =
            $this->attendancesRepository
            ->findAttendance(
                $enrollment,
                $today,
                $session
            );

        if (!$attendance) {

            $attendance = new Attendances();

            $attendance->setStudentEnrollment(
                $enrollment
            );

            $attendance->setAttendanceDate(
                $today
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
    }
}
