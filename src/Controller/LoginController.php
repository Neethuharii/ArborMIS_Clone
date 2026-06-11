<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
final class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('login/index.html.twig');
    }
}
