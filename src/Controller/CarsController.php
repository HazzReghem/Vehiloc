<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Form\CarType;
use App\Repository\CarRepository;
use App\Entity\Car;

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

    #[Route('/car/{id}', name: 'app_car', requirements: ['id' => '\d+'])]
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

    #[Route('/car/{id}/delete', name: 'app_car_delete', methods:['POST'])]
    public function delete(int $id, CarRepository $carRepository, EntityManagerInterface $entityManager): RedirectResponse
    {
        $car  = $carRepository->find($id);

        if (!$car) {
            throw $this->createNotFoundException("Nous ne parvenons pas à trouver cette voiture !");
        }

        // Suppression de la voiture
        $entityManager->remove($car);
        $entityManager->flush();

        $this->addFlash('success', 'La voiture a été supprimée avec succès !');
        
        return $this->RedirectToRoute('app_home');
    }

    #[Route('/car/add', name: 'app_car_add')]
    public function addCar(Request $request, EntityManagerInterface $entityManager): Response
    {
        $car = new Car();

        // Creation du formulaire depuis CarType
        $form = $this->createForm(CarType::class, $car);

        // Traitement de la requête 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Sauvegarder l'objet Car dans la base de données
            $entityManager->persist($car);
            $entityManager->flush();

            $this->addFlash('success', 'La voiture a bien été ajoutée !');

            return $this->redirectToRoute('app_car', ['id' => $car->getId()]); 
        }

        return $this->render('cars/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
