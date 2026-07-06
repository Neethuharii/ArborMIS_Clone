<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\StaffsRepository;
use App\Repository\ClassroomsRepository;
use App\Service\AttendanceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use DateTime;

final class AttendanceController extends AbstractController
{
    #[Route('/attendance', name: 'daily_attendance')]
    public function index(
        AttendanceService $attendanceService,
        StaffsRepository $staffsRepository
    ): Response {
        $isWeekend = !$attendanceService->isAttendanceDay();
        $staff = $isWeekend ? null : $staffsRepository->findStaffById(1);

        return $this->render('Attendances/DailyAttendances.html.twig', [
            'currentSession' => $isWeekend ? null : $attendanceService->getCurrentAttendanceSession(),
            'students' => $isWeekend ? [] : $attendanceService->getStaffStudents($staff),
            'absenceCodes' => $isWeekend ? [] : $attendanceService->getAbsenceCodes(),
            'lateCodes' => $isWeekend ? [] : $attendanceService->getLateCodes(),
            'isWeekend' => $isWeekend,
            'registerDate' => (new DateTime())->format('Y-m-d'),
        ]);
    }

    #[Route('/attendance/save', name: 'attendance_save', methods: ['POST'])]
    public function saveAttendance(
        Request $request,
        AttendanceService $attendanceService
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return $this->json([
                'success' => false,
                'message' => 'Invalid request data'
            ]);
        }

        $studentEnrollmentId = (int) ($data['studentId'] ?? 0);
        $attendanceType = $data['attendanceType'] ?? null;

        if (!$studentEnrollmentId || !$attendanceType) {
            return $this->json([
                'success' => false,
                'message' => 'Missing attendance data'
            ]);
        }

        $sessionContext = $data['session'] ?? $attendanceService->getCurrentAttendanceSession();
        $attendanceDateString = $data['date'] ?? (new DateTime())->format('Y-m-d');
        $attendanceCodeId = (int) ($data['attendanceCodeId'] ?? 0);

        if (!$attendanceCodeId && $attendanceType === 'present') {
            $attendanceCodeId = $attendanceService->getPresentAttendanceCodeId($sessionContext);
        }

        if (!$attendanceCodeId) {
            return $this->json([
                'success' => false,
                'message' => 'Attendance code missing'
            ]);
        }

        try {
            $attendanceService->saveAttendance(
                $studentEnrollmentId,
                $attendanceCodeId,
                $sessionContext,
                1,
                $attendanceDateString,
                isset($data['lateMinutes']) ? (int) $data['lateMinutes'] : null,
                $data['note'] ?? null
            );
        } catch (\Exception $e) {
            return $this->json([
                'success' => false,
                'message' => 'Save failed: ' . $e->getMessage()
            ]);
        }

        $codes = $attendanceType === 'absent'
            ? $attendanceService->getAbsenceCodes()
            : $attendanceService->getLateCodes();

        $response = [
            'success' => true,
            'message' => 'Attendance saved successfully'
        ];

        foreach ($codes as $code) {
            if ($code['id'] === $attendanceCodeId) {
                $response['code'] = $code['code'];
                $response['description'] = $code['description'];
                break;
            }
        }

        return $this->json($response);
    }

    #[Route('/register', name: 'attendance_register')]
    public function attendanceRegister(
        Request $request,
        AttendanceService $attendanceService,
        staffsRepository $staffsRepository
    ): Response {

        $selectedDate = $request->query->get(
            'date',
            (new DateTime())->format('Y-m-d')
        );

        $date = new DateTime($selectedDate);
        $staff = $staffsRepository->findStaffById(1);

        $registers = $attendanceService->isAttendanceDay($date)
            ? $attendanceService->getRegisterByDate(
                $staff,
                $selectedDate
            )
            : [];

        return $this->render(
            'Attendances/AttendanceRegisters.html.twig',
            [
                'selectedDate' => $selectedDate,
                'registers' => $registers,
            ]
        );
    }

    #[Route('/register/{classroomId}/{date}/{session}', name: 'attendance_register_mark')]
    public function markRegister(
        int $classroomId,
        string $date,
        string $session,
        AttendanceService $attendanceService,
        ClassroomsRepository $classroomsRepository,
        StaffsRepository $staffsRepository
    ): Response {
        $classroom = $classroomsRepository->find($classroomId);

        if (!$classroom) {
            throw $this->createNotFoundException('Classroom not found');
        }

        $staff = $staffsRepository->findStaffById(1);
        $registerDate = new DateTime($date);

        $attendanceService->openRegister($classroom, $registerDate, $session, $staff);

        return $this->render('Attendances/DailyAttendances.html.twig', [
            'students' => $attendanceService->getStudentsForRegister($classroom, $registerDate, $session),
            'currentSession' => $session,
            'absenceCodes' => $attendanceService->getAbsenceCodes(),
            'lateCodes' => $attendanceService->getLateCodes(),
            'isWeekend' => false,
            'registerDate' => $date,
        ]);
    }
}
