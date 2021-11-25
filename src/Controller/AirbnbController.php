<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AirbnbController extends AbstractController
{
    #[Route('/', name: 'airbnb')]
    public function index(): Response
    {
        return $this->render('airbnb/index.html.twig', [
            'controller_name' => 'AirbnbController',
        ]);
    }

    #[Route('/properties', name: 'properties')]
    public function properties(): Response
    {
        return $this->render('airbnb/properties.html.twig', [
            'controller_name' => 'AirbnbController',
        ]);
    }

    #[Route('/house', name: 'house')]
    public function house(): Response
    {
        return $this->render('airbnb/house.html.twig', [
            'controller_name' => 'AirbnbController',
        ]);
    }
}
