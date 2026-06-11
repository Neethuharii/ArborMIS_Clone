<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StaffProfileController extends AbstractController
{
    #[Route('/Staff/profile', name: 'sprofile')]
    public function profilepage(): Response
    {
        return $this->render('/Staff/profile.html.twig'); 
    }
}
