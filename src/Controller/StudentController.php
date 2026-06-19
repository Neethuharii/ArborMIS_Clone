<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\GendersRepository;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StudentController extends AbstractController
{
    #[Route('/addstudent', name: 'newstudent')]
    public function index(
        Request $request,
        StudentService $studentService,
        GendersRepository $gendersRepository
    ): Response {
        if ($request->isMethod('POST')) {
            $result = $studentService->createStudent($request);

            if ($result['success']) {
                $this->addFlash('success', 'Student created successfully!');

                return $this->redirectToRoute('newstudent');
            }

            return $this->render('student/AddStudent.html.twig', [
                'genders' => $gendersRepository->findAll(),
                'errors' => $result['errors'],
            ]);
        }

        return $this->render('student/AddStudent.html.twig', [
            'genders' => $gendersRepository->findAll(),
        ]);
    }

    #[Route('/studentList', name: 'studentsList')]
    public function listStudent(
        StudentService $studentService,
        Request $request
    ): Response {
        $search = $request->query->get('search', '');

        return $this->render('student/StudentsList.html.twig', [
            'studentList' => $studentService->listAllStudent($search),
            'search' => $search,
        ]);
    }

    #[Route('/student/{studentId}', name: 'studentProfile')]
    public function studentProfile(
        int $studentId,
        StudentService $studentService
    ): Response {
        $student = $studentService->getStudentById($studentId);

        if (!$student) {
            throw $this->createNotFoundException('Student not found');
        }

        return $this->render('student/StudentProfile.html.twig', [
            'student' => $student,
        ]);
    }

    #[Route(
        '/student/{studentId}/identity/{field}',
        name: 'student_identity_edit',
        methods: ['GET', 'POST']
    )]
    public function editIdentity(
        int $studentId,
        string $field,
        Request $request,
        StudentService $studentService
    ): Response {
        if ($request->isMethod('POST')) {

            $studentService->updateField(
                $studentId,
                $field,
                $request->request->get('value')
            );

            $this->addFlash('success', 'Student updated successfully.');

            return $this->redirectToRoute('studentProfile', [
                'studentId' => $studentId,
            ]);
        }

        return $this->render('student/EditIdentity.html.twig', [
            'data' => $studentService->getEditData(
                $studentId,
                $field
            ),
        ]);
    }
}
