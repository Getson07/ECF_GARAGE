<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Constraints\Length;

#[Route('/car')]
class CarController extends AbstractController
{
    #[Route('/', name: 'app_car_index', methods: ['GET'])]
    public function index(CarRepository $carRepository): Response
    {
        return $this->render('car/index.html.twig', [
            'cars' => $carRepository->findAll(),
        ]);
    }
    public function saveImage(array $imageFiles, string $brand, string $photoDir, string $filename, string $serie='' ) : array{
        $carImages = [];
        if ($imageFiles) {
            $fileIndex = 0;
            $serie = $serie != '' ? $serie.'_' : $serie;
            foreach ($imageFiles as $key => $imageFile) {
                $finalFileName = $filename.'_'.$serie.''.($fileIndex++).preg_replace('/.+\/+/','', $imageFile->getClientMimeType());
                $imageFile->move($photoDir.'/Vehicles/'.$brand.'/', $finalFileName);
                $carImages[] = $finalFileName;
            }
        }
        return $carImages;
    }

    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/new', name: 'app_car_new', methods: ['GET', 'POST'])]
    public function new(Request $request,  #[Autowire('%photo_dir%')] string $photoDir, CarRepository $carRepo): Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form['imageFiles']->getData());
            $serie = $form['serie']->getData()!=null ? $form['serie']->getData() : '';
            $car->setImages(
                            $this->saveImage($form['imageFiles']->getData(), $car->getModel()->getBrand(),
                            $photoDir, $car->getFileName(), $serie)
            );
            $car->setPostedAt(new DateTime());
            $car->setPoster($this->getUser());

            $carRepo->save($car,true);

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('car/new.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_car_show', methods: ['GET'])]
    public function show(Car $car): Response
    {
        return $this->render('car/show.html.twig', [
            'car' => $car,
        ]);
    }

    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/{id}/edit', name: 'app_car_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Car $car, CarRepository $carRepo): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $carRepo->save($car,true);

            return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('car/edit.html.twig', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_EMPLOYE')]
    #[Route('/{id}', name: 'app_car_delete', methods: ['POST'])]
    public function delete(Request $request, Car $car, CarRepository $carRepo): Response
    {
        if ($this->isCsrfTokenValid('delete'.$car->getId(), $request->request->get('_token'))) {
            $carRepo->remove($car,true);
        }

        return $this->redirectToRoute('app_car_index', [], Response::HTTP_SEE_OTHER);
    }
}
