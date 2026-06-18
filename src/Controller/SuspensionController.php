<?php

namespace App\Controller;

use App\Repository\SuspensionReasonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class SuspensionController extends AbstractController
{
    #[Route('/suspension', name: 'app_suspension')]
    public function index(SuspensionReasonRepository $suspensionReasonRepository, Request $request): Response
    {
        return $this->render('Suspension/suspension_reporting.html.twig',[
            'suspensionReasons' => $suspensionReasonRepository->findAll(),
        ]);
    }
}
