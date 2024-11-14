<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Repository\CarRepository;

class CarsController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CarRepository $carRepository): Response
    {
        // Récupération des voitures grâce au Repository
        $cars = $carRepository->findAll();

        return $this->render('cars/index.html.twig', [
            'cars' => $cars,
        ]);
    }

    #[Route('/car/{id}', name: 'app_car')]
    public function car(int $id, CarRepository $carRepository): Response
    {
        // Récupération de la voiture via son ID
        $car = $carRepository->find($id);

        if (!$car) {
            throw this->createNotFoundException("Nous ne parvenons pas à trouver cette voiture !");
        }

        return $this->render('cars/car.html.twig', [
            'car' => $car,
        ]);
    }
}
