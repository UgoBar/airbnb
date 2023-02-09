<?php

namespace App\Controller;

use App\Entity\Apartment;
use App\Entity\Boat;
use App\Entity\House;
use App\Entity\Location;
use App\Entity\Room;
use App\Entity\TreeHouse;
use App\Form\ApartmentType;
use App\Form\BoatType;
use App\Form\HouseType;
use App\Form\RoomCollectionType;
use App\Form\RoomType;
use App\Form\TreeHouseType;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/add/location', name: 'app_add_location')]
    public function index(Request $request): Response
    {
        return $this->render('location/index.html.twig', []);
    }

    #[Route('/my/locations', name: 'app_list_my_location')]
    public function list(Request $request, LocationRepository $locationRepository): Response
    {
        $user = $this->getUser();
        $locations = $locationRepository->findBy(['user' => $user]);
        return $this->render('location/list.html.twig', [
            'locations' => $locations
        ]);
    }

    #[Route('/delete/location/{id}', name: 'app_delete_location', methods: ['GET', 'POST'])]
    public function deleteLocation(Request $request, LocationRepository $locationRepository, Location $location): Response
    {
        $locationRepository->remove($location, true);
        return $this->redirectToRoute('app_list_my_location');
    }

    #[Route('/location/{id}/rooms', name: 'location_rooms', methods: ['GET', 'POST'])]
    public function locationRooms(Request $request, Location $location, EntityManagerInterface $entityManager)
    {

        $form = $this->createForm(RoomCollectionType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            foreach($form->getData()->getroomBeds() as $roomBed) {
//                $roomBed->setRoom($room);
//            }

            $entityManager->persist($location);
            $entityManager->flush();
            return $this->redirectToRoute('app_list_my_location');
        }

        return $this->render('location/rooms.html.twig', [
            'form' => $form,
            'location' => $location
        ]);
    }

    #[Route('/add/location/house', name: 'app_add_house')]
    #[Route('/add/location/apartment', name: 'app_add_apartment')]
    #[Route('/add/location/boat', name: 'app_add_boat')]
    #[Route('/add/location/treeHouse', name: 'app_add_treeHouse')]
    #[Security("is_granted('ROLE_USER')")]
    public function addLocation(Request $request, EntityManagerInterface $entityManager): Response
    {

        $formType = null;
        $location = null;

        // ADD HOUSE
        if($request->get('_route') === 'app_add_house') {
            $location = new House();
            $formType = HouseType::class;
            $locationType = 'Maison';
            $bannerImg = 'https://img.freepik.com/photos-gratuite/piscine_74190-7325.jpg?w=1380&t=st=1675733370~exp=1675733970~hmac=82dda21a55ce6dc477282b4199cb6c1757a99d9adee62b9f01c607ee5854304d';
        }

        // ADD APARTMENT
        if($request->get('_route') === 'app_add_apartment') {
            $location = new Apartment();
            $formType = ApartmentType::class;
            $locationType = 'Appartement';
            $bannerImg = 'https://img.freepik.com/photos-gratuite/salon-chic-moderne-style-esthetique-luxe-dans-tons-gris_53876-132806.jpg?w=1380&t=st=1675733251~exp=1675733851~hmac=b890879ad9655882ff3c425bd52b2a50e4ad98eb85db82fd0829c23bffd73237';
        }

        // ADD TREEHOUSE
        if($request->get('_route') === 'app_add_treeHouse') {
            $location = new TreeHouse();
            $formType = TreeHouseType::class;
            $locationType = 'Tree House';
            $bannerImg = 'https://a0.muscache.com/im/pictures/e8b004b9-1cf0-48fe-a7e1-085afdc19010.jpg?im_w=2560';
        }

        // ADD BOAT
        if($request->get('_route') === 'app_add_boat') {
            $location = new Boat();
            $formType = BoatType::class;
            $locationType = 'Bateau';
            $bannerImg = 'https://img.freepik.com/photos-gratuite/voilier-naviguant-dans-belle-riviere-foret-colline-escarpee_181624-739.jpg?w=1380&t=st=1675733504~exp=1675734104~hmac=c96a1c870d92b793ac824fe5de20296d858963b5f587748b582881c0cbe0572f';
        }

        $form = $this->createForm($formType, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $location->setUser($this->getUser());

            // Ajouter X chambres
            for($i = 0; $i < $form->getData()->getNbrRoom(); $i++) {
                $room = new Room();
                $room->setLocation($location);
                $room->setHasBalcony(0);
                $room->setHasBathroom(0);
                $entityManager->persist($room);
            }

            $entityManager->persist($location);
            $entityManager->flush();

//            return $this->redirectToRoute('app_list_my_location');
            return $this->redirectToRoute('location_rooms', ['id' => $location->getId()]);
        }


        return $this->render('location/form.html.twig', [
            'form' => $form ?? null,
            'locationType' => $locationType ?? null,
            'bannerImg' => $bannerImg ?? null
        ]);
    }

    #[Route('/update/location/{id}', name: 'app_update_location', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER')")]
    public function updateLocation(Request $request, Location $location, EntityManagerInterface $entityManager): Response
    {

        $className = substr(get_class($location), strrpos(get_class($location), '\\') + 1);
        $formType = 'App\Form\\' . $className . 'Type';

        if($className === 'House') {
            $locationType = 'Maison';
            $bannerImg = $location->getPicture() ?: 'https://img.freepik.com/photos-gratuite/piscine_74190-7325.jpg?w=1380&t=st=1675733370~exp=1675733970~hmac=82dda21a55ce6dc477282b4199cb6c1757a99d9adee62b9f01c607ee5854304d';
        }
        else if($className === 'Apartment') {
            $locationType = 'Appartement';
            $bannerImg = $location->getPicture() ?: 'https://img.freepik.com/photos-gratuite/salon-chic-moderne-style-esthetique-luxe-dans-tons-gris_53876-132806.jpg?w=1380&t=st=1675733251~exp=1675733851~hmac=b890879ad9655882ff3c425bd52b2a50e4ad98eb85db82fd0829c23bffd73237';
        }
        else if($className === 'Boat') {
            $locationType = 'Bateau';
            $bannerImg = $location->getPicture() ?: 'https://img.freepik.com/photos-gratuite/voilier-naviguant-dans-belle-riviere-foret-colline-escarpee_181624-739.jpg?w=1380&t=st=1675733504~exp=1675734104~hmac=c96a1c870d92b793ac824fe5de20296d858963b5f587748b582881c0cbe0572f';
        }
        else {
            $locationType = 'Tree House';
            $bannerImg = $location->getPicture() ?: 'https://a0.muscache.com/im/pictures/e8b004b9-1cf0-48fe-a7e1-085afdc19010.jpg?im_w=2560';
        }


        $form = $this->createForm($formType, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//            // Update room number
//            if($location->getNbrRoom() != count($form->getData()->getNbrRoom())) {
//                // More ?
//                if($location->getNbrRoom() < count($form->getData()->getNbrRoom())) {
//                    $diff = count($form->getData()->getNbrRoom()) - $location->getNbrRoom();
//                    // Add X rooms
//                    for($i = 0; $i < $diff; $i++) {
//                        $room = new Room();
//                        $room->setLocation($location);
//                        $room->setHasBalcony(0);
//                        $room->setHasBathroom(0);
//                        $entityManager->persist($room);
//                    }
//                } else {  // Less ?
//                    $diff = $location->getNbrRoom() - count($form->getData()->getNbrRoom());
//                    // Delete X rooms
//
//                }
//
//            }

            $entityManager->persist($location);
            $entityManager->flush();
            return $this->redirectToRoute('app_list_my_location');
        }

        return $this->render('location/form.html.twig', [
            'form' => $form ?? null,
            'locationType' => $locationType ?? null,
            'bannerImg' => $bannerImg ?? null
        ]);
    }
}
