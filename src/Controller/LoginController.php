<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\LoginService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'login', methods: ['GET', 'POST'])]
    public function login(
        Request $request,
        LoginService $loginService
    ): Response {
        if ($request->isMethod('POST')) {

            $email = (string) $request->request->get('email');
            $password = (string) $request->request->get('password');

            $isValidUser = $loginService->authenticate(
                $email,
                $password
            );

            if ($isValidUser) {
                return $this->redirectToRoute('homepage');
            }

            return $this->render('login/index.html.twig', [
                'error' => 'Invalid email or password.',
            ]);
        }

        return $this->render('login/index.html.twig');
    }
}
