<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(LocationRepository $locationRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/search/location', name: 'app_search_location', methods: ['GET', 'POST'])]
    public function searchLocation(Request $request, LocationRepository $locationRepository): Response
    {

        if(!$request->get('dateRange') || !$request->get('travellerNumber') || !$request->get('where')) {
            return $this->redirectToRoute('app_home');
        }

        $dateRange = explode(' - ', $request->get('dateRange'));
        $params = [
            'travellerNumber' => $request->get('travellerNumber') ?: 0,
            'startAt'         => $dateRange[0],
            'endAt'           => $dateRange[1],
            'where'           => $request->get('where') ?: null,
        ];

        $locations = $locationRepository->searchLocationsByParams($params);
        return $this->render('home/search.html.twig', [
            'locations' => $locations,
        ]);
    }
}
