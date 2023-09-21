<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/registration', name: 'app_registration')]
    public function registration(): Response
    {
        return $this->redirectToRoute('app_user_new');
    }
   
    #[Route('/services', name: 'app_services')]
    public function services(): Response
    {
        return $this->redirectToRoute('app_service_new');
    }

    #[Route('/schedules', name: 'app_schedules')]
    public function schedules(): Response
    {
        return $this->redirectToRoute('app_opening_hours_index');
    }
}
