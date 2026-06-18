<?php

namespace App\Controller\Suspension_controllers;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SuspensionController extends AbstractController
{
    #[Route('/suspension', name: 'app_suspension')]
    public function index(): Response
    {
        return $this->render('Suspension/suspension_reporting.html.twig');
    }
}
