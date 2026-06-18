<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\StaffService;

final class AddStaffController extends AbstractController
{
    #[Route('/Staff/addstaff', name: 'addstaff')]

    public function addstaff(StaffService $addstaffService, Request $request):Response
    {
        $genders = $addstaffService->getAllGenders();
        $titles = $addstaffService->getAllTitles();
        $businessRoles = $addstaffService->getAllBusinessRoles();

        if ($request->isMethod('POST')) {
            $data = $addstaffService->addStaff($request);

            if ($data['success']) {
                $this->addFlash('success', 'Staff member created successfully!');
                return $this->redirectToRoute('addstaff');
            }
        }
            return $this->render('Staff/addstaff.html.twig', [
                'all_genders' => $genders,
                'all_titles' => $titles,
                'all_businessRoles' => $businessRoles,
            ]);
    }
}
