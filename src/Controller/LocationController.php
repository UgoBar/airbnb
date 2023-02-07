<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Entity\Boat;
use App\Entity\House;
use App\Entity\Location;
use App\Entity\TreeHouse;
use App\Form\ApartmentType;
use App\Form\BoatType;
use App\Form\HouseType;
use App\Form\TreeHouseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/add/location', name: 'app_add_location')]
    public function index(Request $request): Response
    {

        return $this->render('location/index.html.twig', [

        ]);
    }

    // ADD HOUSE
    #[Route('/add/location/house', name: 'app_add_house')]
    public function addHouse(Request $request, EntityManagerInterface $entityManager): Response
    {
        $location = new House();
        $form = $this->createForm(HouseType::class, $location);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location->setUser($this->getUser());
            $entityManager->persist($location);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('location/form.html.twig', [
            'form' => $form,
            'pageTitle' => 'Add House'
        ]);
    }

    // ADD APARTMENT
    #[Route('/add/location/apartment', name: 'app_add_apartment')]
    public function addApartment(Request $request, EntityManagerInterface $entityManager): Response
    {
        $location = new Apartment();
        $form = $this->createForm(ApartmentType::class, $location);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location->setUser($this->getUser());
            $entityManager->persist($location);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('location/form.html.twig', [
            'form' => $form,
            'pageTitle' => 'Add Apartment'
        ]);
    }

    // ADD TREE HOUSE
    #[Route('/add/location/treeHouse', name: 'app_add_treeHouse')]
    public function addTreeHouse(Request $request, EntityManagerInterface $entityManager): Response
    {
        $location = new TreeHouse();
        $form = $this->createForm(TreeHouseType::class, $location);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location->setUser($this->getUser());
            $entityManager->persist($location);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('location/form.html.twig', [
            'form' => $form,
            'pageTitle' => 'Add Tree House'
        ]);
    }

    // ADD BOAT
    #[Route('/add/location/treeHouse', name: 'app_add_boat')]
    public function addBoat(Request $request, EntityManagerInterface $entityManager): Response
    {
        $location = new Boat();
        $form = $this->createForm(BoatType::class, $location);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location->setUser($this->getUser());
            $entityManager->persist($location);
            $entityManager->flush();
            return $this->redirectToRoute('app_home');
        }

        return $this->render('location/form.html.twig', [
            'form' => $form,
            'pageTitle' => 'Add Boat'
        ]);
    }
}
