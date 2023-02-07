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
    #[Route('/add/location/house', name: 'app_add_house')]
    #[Route('/add/location/apartment', name: 'app_add_apartment')]
    #[Route('/add/location/boat', name: 'app_add_boat')]
    #[Route('/add/location/treeHouse', name: 'app_add_treeHouse')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {

        $view = $request->get('_route') === 'app_add_location' ? 'location/index.html.twig' : 'location/form.html.twig';

        // ADD HOUSE
        if($request->get('_route') === 'app_add_house') {
            $location = new House();
            $form = $this->createForm(HouseType::class, $location);
            $locationType = 'Maison';
            $bannerImg = 'https://img.freepik.com/photos-gratuite/piscine_74190-7325.jpg?w=1380&t=st=1675733370~exp=1675733970~hmac=82dda21a55ce6dc477282b4199cb6c1757a99d9adee62b9f01c607ee5854304d';
        }

        // ADD APARTMENT
        if($request->get('_route') === 'app_add_apartment') {
            $location = new Apartment();
            $form = $this->createForm(ApartmentType::class, $location);
            $locationType = 'Appartement';
            $bannerImg = 'https://img.freepik.com/photos-gratuite/salon-chic-moderne-style-esthetique-luxe-dans-tons-gris_53876-132806.jpg?w=1380&t=st=1675733251~exp=1675733851~hmac=b890879ad9655882ff3c425bd52b2a50e4ad98eb85db82fd0829c23bffd73237';
        }

        // ADD TREEHOUSE
        if($request->get('_route') === 'app_add_treeHouse') {
            $location = new TreeHouse();
            $form = $this->createForm(TreeHouseType::class, $location);
            $locationType = 'Tree House';
            $bannerImg = 'https://a0.muscache.com/im/pictures/e8b004b9-1cf0-48fe-a7e1-085afdc19010.jpg?im_w=2560';
        }

        // ADD HOUSE
        if($request->get('_route') === 'app_add_boat') {
            $location = new Boat();
            $form = $this->createForm(BoatType::class, $location);
            $locationType = 'Bateau';
            $bannerImg = 'https://img.freepik.com/photos-gratuite/voilier-naviguant-dans-belle-riviere-foret-colline-escarpee_181624-739.jpg?w=1380&t=st=1675733504~exp=1675734104~hmac=c96a1c870d92b793ac824fe5de20296d858963b5f587748b582881c0cbe0572f';
        }

        if(isset($form) && isset($location)) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $location->setUser($this->getUser());
                $entityManager->persist($location);
                $entityManager->flush();
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render($view, [
            'form' => $form ?? null,
            'locationType' => $locationType ?? null,
            'bannerImg' => $bannerImg ?? null
        ]);
    }

//    // ADD HOUSE
//    #[Route('/add/location/house', name: 'app_add_house')]
//    public function addHouse(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $location = new House();
//        $form = $this->createForm(HouseType::class, $location);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $location->setUser($this->getUser());
//            $entityManager->persist($location);
//            $entityManager->flush();
//            return $this->redirectToRoute('app_home');
//        }
//
//        return $this->render('location/form.html.twig', [
//            'form' => $form,
//            'locationType' => 'Maison',
//            'bannerImg' => 'https://img.freepik.com/photos-gratuite/piscine_74190-7325.jpg?w=1380&t=st=1675733370~exp=1675733970~hmac=82dda21a55ce6dc477282b4199cb6c1757a99d9adee62b9f01c607ee5854304d'
//        ]);
//    }
//
//    // ADD APARTMENT
//    #[Route('/add/location/apartment', name: 'app_add_apartment')]
//    public function addApartment(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $location = new Apartment();
//        $form = $this->createForm(ApartmentType::class, $location);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $location->setUser($this->getUser());
//            $entityManager->persist($location);
//            $entityManager->flush();
//            return $this->redirectToRoute('app_home');
//        }
//
//        return $this->render('location/form.html.twig', [
//            'form' => $form,
//            'locationType' => 'Appartement',
//            'bannerImg' => 'https://img.freepik.com/photos-gratuite/salon-chic-moderne-style-esthetique-luxe-dans-tons-gris_53876-132806.jpg?w=1380&t=st=1675733251~exp=1675733851~hmac=b890879ad9655882ff3c425bd52b2a50e4ad98eb85db82fd0829c23bffd73237'
//        ]);
//    }
//
//    // ADD TREE HOUSE
//    #[Route('/add/location/treeHouse', name: 'app_add_treeHouse')]
//    public function addTreeHouse(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $location = new TreeHouse();
//        $form = $this->createForm(TreeHouseType::class, $location);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $location->setUser($this->getUser());
//            $entityManager->persist($location);
//            $entityManager->flush();
//            return $this->redirectToRoute('app_home');
//        }
//
//        return $this->render('location/form.html.twig', [
//            'form' => $form,
//            'locationType' => 'Tree House',
//            'bannerImg' => 'https://a0.muscache.com/im/pictures/e8b004b9-1cf0-48fe-a7e1-085afdc19010.jpg?im_w=2560'
//        ]);
//    }
//
//    // ADD BOAT
//    #[Route('/add/location/boat', name: 'app_add_boat')]
//    public function addBoat(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        $location = new Boat();
//        $form = $this->createForm(BoatType::class, $location);
//
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $location->setUser($this->getUser());
//            $entityManager->persist($location);
//            $entityManager->flush();
//            return $this->redirectToRoute('app_home');
//        }
//
//        return $this->render('location/form.html.twig', [
//            'form' => $form,
//            'locationType' => 'Bateau',
//            'bannerImg' => 'https://img.freepik.com/photos-gratuite/voilier-naviguant-dans-belle-riviere-foret-colline-escarpee_181624-739.jpg?w=1380&t=st=1675733504~exp=1675734104~hmac=c96a1c870d92b793ac824fe5de20296d858963b5f587748b582881c0cbe0572f'
//        ]);
//    }
}
