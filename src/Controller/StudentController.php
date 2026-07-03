<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Students;
use App\Repository\CardsRepository;
use App\Repository\CountriesRepository;
use App\Repository\DocumentTypesRepository;
use App\Repository\EthnicitiesRepository;
use App\Repository\GendersRepository;
use App\Repository\NationalityRepository;
use App\Repository\RelationshipTypesRepository;
use App\Repository\ReligionsRepository;
use App\Repository\StudentGuardianRelationRepository;
use App\Repository\StudentsRepository;
use App\Repository\TitlesRepository;
use App\Service\StudentService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

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
        ReligionsRepository $religionsRepository,
        RelationshipTypesRepository $relationshipTypesRepository,
        StudentGuardianRelationRepository $studentGuardianRelationRepository,
        CardsRepository $cardsRepository,
        DocumentTypesRepository $documentTypesRepository,
        TitlesRepository $titlesRepository
    ): Response {

        $student = $studentService->getStudentById($studentId);

        if (!$student) {
            throw $this->createNotFoundException('Student not found');
        }

        return $this->render('student/StudentProfile.html.twig', [
            'student' => $student,
            'entity'            => $student,
            'entityId'          => $student->getStudentId(),
            'guardianRelations' => $studentGuardianRelationRepository->findBy(['student' => $student]),
            'genders' => $gendersRepository->findAll(),
            'countries' => $countriesRepository->findAll(),
            'ethnicities' => $ethnicitiesRepository->findAll(),
            'nationalities' => $nationalityRepository->findAll(),
            'religions' => $religionsRepository->findAll(),
            'relationships' => $relationshipTypesRepository->findAll(),
            'card' => $cardsRepository->findAll(),
            'documentTypes' => $documentTypesRepository->findAll(),
            'titles' => $titlesRepository->findAll()
        ]);
    }

    #[Route('/student/{id}/update', name: 'student_update', methods: ['POST'])]
    public function update(
        int $id,
        Request $request,
        StudentService $studentService,
        StudentsRepository $studentsRepository
    ): Response {

        if ($id === 0) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid Student ID provided.'], 400);
        }

        $student = $studentsRepository->find($id);

        if (!$student) {
            return $this->json(['success' => false, 'message' => 'Student member not found.'], 404);
        }

        try {
            $studentService->updateStudent($student, $request);
            return $this->json(['success' => true]);
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => 'Unable to save changes']);
        }
    }

    #[Route('/student/{id}/document', name: 'student_document', methods: ['POST'])]
    public function uploadDocument(int $id, Request $request, StudentsRepository $studentsRepository, StudentService $studentService): Response
    {
        if ($id === 0) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid Student ID provided.'], 400);
        }

        $student = $studentsRepository->find($id);

        if (!$student) {
            return $this->json(['success' => false, 'message' => 'Student member not found.'], 404);
        }

        try {
            $studentService->updateStudentDocuments($student, $request);
            return $this->json(['success' => true]);
        } catch (Exception $e) {
            return $this->json(['success' => false, 'message' => 'Unable to upload document']);
        }
    }

    #[Route('/student/{id}/idcard', name: 'student_idcard', methods: ['POST'])]
    public function uploadIdCard(int $id, Request $request, StudentService $studentService, StudentsRepository $studentsRepository): Response
    {
        if ($id === 0) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid Student ID provided.'], 400);
        }
        $student = $studentsRepository->find($id);

        if (!$student) {
            return $this->json(['success' => false, 'message' => 'Student member not found.'], 404);
        }

        try {
            $studentService->updateStudentCard($student, $request);
            return $this->json(['success' => true]);
        } catch (Throwable $e) {
            return $this->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    #[Route('/student/{studentId}/guardian/add', name: 'guardian_add', methods: ['POST'])]
    public function addGuardian(
        int $studentId,
        Request $request,
        StudentService $studentService
    ): Response {

        $student = $studentService->getStudentById($studentId);

        if (!$student) {
            throw $this->createNotFoundException('Student not found');
        }

        $studentService->createGuardianForStudent($request->request->all(), $student, $request);

        $this->addFlash('success', 'Guardian added successfully');

        return $this->redirectToRoute('studentProfile', [
            'studentId' => $studentId
        ]);
    }
    #[Route(
        '/student/{id}/upn/delete',
        name: 'student_delete_upn',
        methods: ['POST']
    )]
 #[Route('/student/{id}/upn/delete', name: 'student_delete_upn', methods: ['POST'])]
public function deleteUpn(
    int $id,
    StudentService $studentService
): RedirectResponse {
    $student = $studentService->getStudentById($id);

    if (!$student) {
        throw $this->createNotFoundException('Student not found.');
    }

    $studentService->deleteUpn($student);

    $this->addFlash('success', 'UPN deleted successfully.');

    return $this->redirectToRoute('studentProfile', [
        'studentId' => $student->getStudentId(),
    ]);
}

    #[Route('/student/{id}/assign-upn', name: 'student_assign_upn', methods: ['POST'])]
    public function assignUpn(
        Students $student,
        Request $request,
        EntityManagerInterface $em,
        StudentService $studentService
    ): JsonResponse {

        $existingUpn = trim($request->request->get('existingUpn'));

        if ($existingUpn !== '') {

            $alreadyExists = $em->getRepository(Students::class)
                ->findOneBy(['upn' => $existingUpn]);

            if ($alreadyExists) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'This UPN already exists.'
                ]);
            }

            $student->setUpn($existingUpn);
        } else {

            $student->setUpn($studentService->generateUpn());
        }

        $em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'UPN assigned successfully.'
        ]);
    }
}
