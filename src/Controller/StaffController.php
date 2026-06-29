<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Staffs;
use App\Repository\GendersRepository;
use App\Repository\EthnicitiesRepository;
use App\Repository\ReligionsRepository;
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
    public function profile(int $id, StaffService $staffService,GendersRepository $gendersRepository,EthnicitiesRepository $ethnicitiesRepository,ReligionsRepository $religionsRepository): Response
    {
        $staff = $staffService->getStaffById($id);
        if (!$staff) {
            throw $this->createNotFoundException('Staff not found');
        }

        return $this->render('Staff/profile.html.twig', ['staff' => $staff,
        'all_genders' => $gendersRepository->findAll(),
        'all_ethnicities' => $ethnicitiesRepository->findAll(),
        'all_religions' => $religionsRepository->findAll()
        ]);
    }

    #[Route('/Staff/{id}/update', name: 'staff_update', methods: ['POST'])]
    public function update(Staffs $staff, Request $request, StaffService $staffService ): JsonResponse {

        $staffService->updateStaff($staff, $request);

        return $this->json([ 'success' => true]);
    }
}
