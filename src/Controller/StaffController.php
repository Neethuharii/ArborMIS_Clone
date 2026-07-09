<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Staffs;
use App\Repository\CurrentRolesRepository;
use App\Repository\StaffsRepository;
use App\Service\StaffService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class StaffController extends AbstractController
{
    #[Route('/Staff/addstaff', name: 'addstaff')]
    public function addstaff(StaffService $addstaffService, Request $request): Response
    {
        $genders = $addstaffService->getAllGenders();
        $titles = $addstaffService->getAllTitles();
        $businessRoles = $addstaffService->getAllBusinessRoles();

        if ($request->isMethod('POST')) {
            $data = $addstaffService->addStaff($request);

            if ($data['success']) {
                return $this->redirectToRoute('browseStaff');
            }
        }
        return $this->render('Staff/addstaff.html.twig', [
            'all_genders' => $genders,
            'all_titles' => $titles,
            'all_businessRoles' => $businessRoles,
        ]);
    }

    #[Route('/Staff/browseStaff', name: 'browseStaff')]
    public function list(StaffService $staffService): Response
    {
        return $this->render('Staff/browseStaff.html.twig', ['staffs' => $staffService->getAllStaffs()]);
    }

    #[Route('/Staff/profile/{id}', name: 'staffProfile')]
    public function profile(int $id, StaffService $staffService, CurrentRolesRepository $currentRolesRepository): Response
    {
        $staff = $staffService->getStaffById($id);
        if (!$staff) {
            throw $this->createNotFoundException('Staff not found');
        }

        $allRoles = $currentRolesRepository->findBy(
            ['staff' => $staff],
            ['startDate' => 'DESC']
        );

        return $this->render('Staff/profile.html.twig', [
            'staff'             => $staff,
            'entity'            => $staff,
            'entityId'          => $staff->getStaffId(),
            'entityType'        => 'staff',
            'allRoles'          => $allRoles,
            'qualification_types' => $staffService->getAllQualificationTypes(),
            'all_staffs' => $staffService->getAllStaffs(),
            'all_genders'       => $staffService->getAllGenders(),
            'all_ethnicities'   => $staffService->getAllEthnicities(),
            'all_religions'     => $staffService->getAllReligions(),
            'documentTypes'     => $staffService->getAllDocumentTypes(),
            'countries'         => $staffService->getAllCountries(),
            'all_businessRoles' => $staffService->getAllBusinessRoles(),
            'all_nationalities' => $staffService->getAllNationalities(),
            'allQualifications'=> $staffService->getAllQualificationChecks() 
        ]);
    }

    #[Route('/Staff/{id}/update', name: 'staff_update', methods: ['POST'])]
    public function update(int $id,  Request $request, StaffsRepository $staffRepository,  StaffService $staffService): Response
    {
        if ($id === 0) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid Staff ID provided.'], 400);
        }

        $staff = $staffRepository->find($id);

        if (!$staff) {
            return $this->json(['success' => false, 'message' => 'Staff member not found.'], 404);
        }

        try {
            $staffService->updateStaff($staff, $request);
            return $this->json(['success' => true]);
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => 'Unable to save changes']);
        }
    }

    #[Route('/Staff/{id}/document', name: 'staff_document', methods: ['POST'])]
    public function uploadDocument(int $id, Request $request, StaffsRepository $staffRepository, StaffService $staffService): Response
    {
        if ($id === 0) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid Staff ID provided.'], 400);
        }

        $staff = $staffRepository->find($id);

        if (!$staff) {
            return $this->json(['success' => false, 'message' => 'Staff member not found.'], 404);
        }

        try {
            $staffService->updateStaffDocuments($staff, $request);
            return $this->json(['success' => true]);
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => 'Unable to upload document']);
        }
    }

    #[Route('/Staff/{id}/idcard', name: 'staff_idcard', methods: ['POST'])]
    public function uploadIdCard(int $id, Request $request, StaffService $staffService, StaffsRepository $staffRepository): Response
    {
        if ($id === 0) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid Staff ID provided.'], 400);
        }
        $staff = $staffRepository->find($id);

        if (!$staff) {
            return $this->json(['success' => false, 'message' => 'Staff member not found.'], 404);
        }

        try {
            $staffService->updateStaffCard($staff, $request);
            return $this->json(['success' => true]);
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => 'Unable to upload Id card']);
        }
    }

    #[Route('/Staff/{id}/address', name: 'staff_address', methods: ['POST'])]
    public function updateAddress(int $id, Request $request, StaffsRepository $staffRepository, StaffService $staffService): Response
    {
        if ($id === 0) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid Staff ID provided.'], 400);
        }
        $staff = $staffRepository->find($id);

        if (!$staff) {
            return new JsonResponse(['success' => false, 'message' => 'Staff member not found'], 400);
        }
        try {
            $staffService->updateAddress($staff, $request);
            return $this->json(['success' => true]);
        } catch (\Exception $e) {
            return $this->json(['success' => false, 'message' => 'Unable to upload staff address']);
        }
    }

    #[Route('/Staff/{id}/role', name: 'business_role', methods: ['POST', 'GET'])]
    public function addBusinessRole(int $id, Request $request, StaffsRepository $staffRepository, StaffService $staffService): Response
    {
        if ($id === 0) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid Staff ID provided.'], 400);
        }

        $staff = $staffRepository->find($id);
        if (!$staff) {
            return new JsonResponse(['success' => false, 'message' => 'Staff member not found.'], 400);
        }

        if ($request->isMethod('POST')) {
            try {
                $staffService->addBusinessRole($staff, $request);
                return $this->json(['success' => true]);
            } catch (Exception $e) {
                return new JsonResponse(['success' => false, 'message' => 'Unable to add role: ' . $e->getMessage()], 400);
            }
        }

        return $this->render('Slideover/businessRole.html.twig', [
            'staff' => $staff,
            'all_businessRoles' => $staffService->getAllBusinessRoles()
        ]);
    }

    #[Route('/Staff/{id}/profile-photo', name: 'profile_picture', methods: ['POST'])]
    public function addProfilePhoto(Staffs $staff, Request $request, StaffService $staffService): Response
    {
        $photo = $request->files->get('profile');
        if ($photo) {
            $staffService->uploadProfilePicture($staff, $photo);
        }
        return $this->redirectToRoute('staffProfile', [
            'id' => $staff->getStaffId()
        ]);
    }

    #[Route('Staff/{id}/qualification', name: 'qualification_check', methods: ['POST'])]
    public function addQualificationCheck(int $id, Staffs $staff, StaffService $staffService, Request $request, StaffsRepository $staffRepository)
    {
        if ($id === 0) {
            return new JsonResponse(['success' => false, 'message' => 'Invalid Staff ID provided.'], 400);
        }


        $staff = $staffRepository->find($id);
        if (!$staff) {
            return new JsonResponse(['success' => false, 'message' => 'Staff member not found.'], 400);
        }

        if ($request->isMethod('POST')) {
            try {
                $staffService->addQualificationCheck($staff, $request);
                return $this->json(['success' => true]);
            } catch (Exception $e) {
                return new JsonResponse(['success' => false, 'message' => 'Unable to add role: ' . $e->getMessage()], 400);
            }
        }

        return $this->render('Slideover/qualificationChecks.html.twig', [
            'staff' => $staff,
            'all_staffs' => $staffService->getAllStaffs()
        ]);
    }
}
