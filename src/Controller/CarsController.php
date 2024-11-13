<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\CarsRepository;

class CarsController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CarRepository $carRepository): Response
    {
        // Récupération des voitures grâce au Repository
        $cars = $carRepository->findAll();

        return $this->render('cars/index.html.twig', [
            'controller_name' => 'CarsController',
        ]);
    }
}
