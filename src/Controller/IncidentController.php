<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\StudentsRepository;
use App\Repository\BehavioursRepository;
use App\Repository\StaffsRepository;
use App\Repository\InterventionRepository;
use App\Repository\BehaviourIncidentsRepository;
use App\Service\IncidentService;

final class IncidentController extends AbstractController
{
    #[Route('/incident', name: 'app_incident')]
    public function index(
        Request $request,
        StudentsRepository $studentRepo,
        BehavioursRepository $behaviourRepo,
        StaffsRepository $staffsRepo,
        InterventionRepository $interventionRepo,
        BehaviourIncidentsRepository $incidentRepo,
        IncidentService $incidentService
    ): Response {
        if ($request->isMethod('POST')) {
            $result = $incidentService->createIncident($request);

            return new JsonResponse($result);
        }

        return $this->render('Behaviour/behaviour_incident.html.twig', [
            'students' => $studentRepo->findAll(),
            'behaviours' => $behaviourRepo->findAll(),
            'staffs' => $staffsRepo->findAll(),
            'interventionMethods' => $interventionRepo->findAll(),
            'incidents' => $incidentRepo->findAll()
        ]);
    }

    #[Route('/incidents/search', name:'app_incidents_search')]
    public function incidentsSearch(Request $request, IncidentService $incidentService): Response
    {
        $search = $request->query->get('search','');

        return $this->json(
            $incidentService->incidentsSearch($search)
        );
    }
}