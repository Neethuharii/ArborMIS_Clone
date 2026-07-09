<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\StudentPointsRepository;
use App\Repository\BehaviourIncidentsRepository;
use App\Service\IncidentService;
use Symfony\Component\HttpFoundation\JsonResponse;

class PointsController extends AbstractController{
    #[Route('/points/recent', name:'app_points_recent')]
    public function recent(BehaviourIncidentsRepository $behaviourIncidentsRepo):Response
    {
        return $this->render('Point-awards/recent-points.html.twig',[
            'incidents'=>$behaviourIncidentsRepo->findAll()
        ]);
    }

    #[Route('/points/total' , name:'app_points_total')]
    public function total(StudentPointsRepository $studentPointRepo):Response
    {
        return $this->render('Point-awards/total-points.html.twig',[
            'totals'=>$studentPointRepo->findAll()
        ]);
    }

    #[Route('/recent-points/search', name:'app_recent_points_search')]
    public function search(Request $request, IncidentService $incidentService):JsonResponse
    {
        $search = $request->query->get('search','');

        return $this->json(
           $incidentService->searchRecentPoints($search)
        );
    }

    #[Route('/total-points/search', name: 'app_points_total_search')]
    public function searchTotalPoints(
        Request $request,
        IncidentService $studentPointsService
    ): JsonResponse {
        $search = $request->query->get('search', '');

        return $this->json(
            $studentPointsService->searchTotalPoints($search)
        );
    }
}