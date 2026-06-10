<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TeacherProfileController extends AbstractController
{
    #[Route('/Staff/profile',name:'tprofile')]
    public function profilepage():Response{
        return $this->render('/Staff/profile.html.twig');
    }
}