<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CountriesRepository;
use App\Repository\GendersRepository;
use App\Repository\EthnicitiesRepository;
use App\Repository\ReligionsRepository;
use App\Repository\DocumentTypesRepository;
use App\Repository\NationalityRepository;
use App\Repository\StaffsRepository;
use App\Service\StaffService;
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
    public function profile(
        int $id, 
        StaffService $staffService, 
        GendersRepository $gendersRepository, 
        EthnicitiesRepository $ethnicitiesRepository, 
        ReligionsRepository $religionsRepository, 
        DocumentTypesRepository $documentTypesRepository, 
        CountriesRepository $countriesRepository, 
        NationalityRepository $nationalityRepository
    ): Response {
        $staff = $staffService->getStaffById($id);
        if (!$staff) {
            throw $this->createNotFoundException('Staff not found');
        }

        return $this->render('Staff/profile.html.twig', [
            'staff' => $staff,
            'entity'            => $staff,                    
            'entityId'          => $staff->getStaffId(),      
            'entityType'        => 'staff',                   
            'all_genders'       => $gendersRepository->findAll(),
            'all_ethnicities'   => $ethnicitiesRepository->findAll(),
            'all_religions'     => $religionsRepository->findAll(),
            'documentTypes'     => $documentTypesRepository->findAll(),
            'countries'         => $countriesRepository->findAll(),
            'all_nationalities' => $nationalityRepository->findAll()
        ]);
    }

   #[Route('/Staff/{id}/update', name: 'staff_update', methods: ['POST'])]
    public function update($id,  Request $request,StaffsRepository $staffRepository,  StaffService $staffService ): Response {
    $id = (int) $id;

    if ($id === 0) {
        return new JsonResponse(['success' => false, 'message' => 'Invalid Staff ID provided.'], 400);
    }

    $staff = $staffRepository->find($id);

    if (!$staff) {
        return $this->json(['success' => false, 'message' => 'Staff member not found.'], 404);
    }

    try {
        $staffService->updateStaff($staff, $request);
        
        return $this->json([
            'success' => true
        ]);
    } catch (\Exception $e) {
        error_log($e->getMessage()); 

        return $this->json([
            'success' => false,
            'message' => 'Unable to save changes. Error: ' . $e->getMessage()
        ], 400);
    }
}
}
