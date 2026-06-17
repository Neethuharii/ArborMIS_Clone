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
    #[Route('/student', name: 'app_student')]
    public function index(
        Request $request,
        StudentService $studentService,
        GendersRepository $gendersRepository
    ): Response {

        if ($request->isMethod('POST')) {

            $result = $studentService->createStudent($request);

            if ($result['success']) {
                return $this->redirectToRoute('homepage');
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
}
