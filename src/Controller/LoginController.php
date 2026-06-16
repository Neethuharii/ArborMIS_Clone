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
    #[Route('/login', name: 'login')]
    public function login(Request $request,LoginService $loginService): Response {
        if ($request->isMethod('POST')) {
             $email = trim((string) $request->request->get('email', ''));
            $password = (string) $request->request->get('password', '');
            $result = $loginService->authenticate($email, $password);
            if ($result['success']) {
                return $this->redirectToRoute('homepage');
            }
            return $this->render('login/index.html.twig', [
                'emailError' => $result['emailError'],
                'passwordError' => $result['passwordError'],
            ]);
        }
        return $this->render('login/index.html.twig');
    }

}
