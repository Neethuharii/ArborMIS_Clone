<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class HomepageController extends AbstractController{
    #[Route('/Homepage/home',name:'homepage')]
    public function homepage():Response{
        return $this->render('/Homepage/home.html.twig');
    }
}
?>