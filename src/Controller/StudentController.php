<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Students;
use App\Repository\CountriesRepository;
use App\Repository\EthnicitiesRepository;
use App\Repository\GendersRepository;
use App\Repository\NationalityRepository;
use App\Repository\ReligionsRepository;
use App\Service\StudentService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        StudentService $studentService,
        GendersRepository $gendersRepository,
        CountriesRepository $countriesRepository,
        EthnicitiesRepository $ethnicitiesRepository,
        NationalityRepository $nationalityRepository,
        ReligionsRepository $religionsRepository
    ): Response {

        $student = $studentService->getStudentById($studentId);

        if (!$student) {
            throw $this->createNotFoundException('Student not found');
        }

        return $this->render('student/StudentProfile.html.twig', [
            'student' => $student,
            'genders' => $gendersRepository->findAll(),
            'countries'=> $countriesRepository->findAll(),
            'ethnicities' => $ethnicitiesRepository->findAll(),
            'nationalities'=>$nationalityRepository->findAll(),
            'religions'=>$religionsRepository->findAll()
        ]);
    }
#[Route('/student/{id}/update', name: 'student_update', methods: ['POST'])]
public function update(
    Students $student,
    Request $request,
    StudentService $studentService
): JsonResponse {

    $studentService->updateStudent($student, $request);

    return $this->json([
        'success' => true
    ]);
}
}
