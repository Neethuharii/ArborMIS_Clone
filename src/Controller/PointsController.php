<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\StudentPointsRepository;
use App\Repository\BehaviourIncidentsRepository;

class PointsController extends AbstractController{
    #[Route('/points/recent', name:'app_points_recent')]
    public function recent(StudentPointsRepository $studentPointRepo, BehaviourIncidentsRepository $behaviourIncidentsRepo):Response
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
}