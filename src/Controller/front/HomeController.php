<?php

namespace App\Controller\front;

use App\Repository\RecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class HomeController extends AbstractController
{
    #[Route('/', name: 'home_index')]
    public function index(RecetteRepository $recetteRepository): Response
    {
        $recipes = $recetteRepository->findAll();

        return $this->render('front/home/index.html.twig', ['recipes'=>$recipes]);
    }
}
