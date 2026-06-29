<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class IncidentController extends AbstractController
{
    #[Route('/incident',name:'app_incident')]
    public function index(Request $request):Response
    {
        return $this->render('Behaviour/behaviour_incident.html.twig');
    }
}