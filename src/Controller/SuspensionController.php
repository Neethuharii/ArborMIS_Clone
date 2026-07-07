<?php

namespace App\Controller;

use App\Repository\SuspensionReasonRepository;
use App\Repository\StudentsRepository;
use App\Service\SuspensionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class SuspensionController extends AbstractController
{
    #[Route('/suspension-reporting', name: 'app_suspension_reporting')]
    public function index(SuspensionReasonRepository $suspensionReasonRepository, StudentsRepository $studentsRepository, Request $request, SuspensionService $suspensionService): Response
    {  
        if($request->isMethod('POST')){
            $result= $suspensionService->createSuspension($request);
            if($result['success']){
                $this->addFlash('success','created suspension record successfully');
                return $this->redirectToRoute('app_suspension_reporting');
            }

            return $this->render('Suspension/suspension_reporting.html.twig',[
                'suspensionReasons' => $suspensionReasonRepository->findAll(),
                'suspensions' => $suspensionService->getSuspensionDetails(),
                'students' => $studentsRepository->findAll(),
                'errors' => $result['errors']
            ]);

        }
        return $this->render('Suspension/suspension_reporting.html.twig',[
            'suspensionReasons' => $suspensionReasonRepository->findAll(),
            'students' => $studentsRepository->findAll(),
            'suspensions' => $suspensionService->getSuspensionDetails()
        ]);
    }

    #[Route('/suspension-statistics', name:'app_suspension_statistics')]
    public function statistics(SuspensionService $suspensionService):Response
    {
        return $this->render('Suspension/suspension_statistics.html.twig',[
            'stats' => $suspensionService->getSuspensionStats()
        ]);
    }
}
