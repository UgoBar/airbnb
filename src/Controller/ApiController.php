<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ApiController extends AbstractController
{
    #[Security("is_granted('ROLE_USER')")]
    #[Route('/api/get/city/{term}', name: 'app_api_get_city')]
    public function index(EntityManagerInterface $entityManager, ?string $term = null): Response
    {
        if($term !== null) {
            $conn = $entityManager->getConnection();
            $sql = 'SELECT ville_nom, ville_nom_reel, ville_code_postal FROM spec_villes_france WHERE ville_nom_reel LIKE :term';
            $result = $conn->prepare($sql)->executeQuery(['term' => '%'.$term.'%'])->fetchAllAssociative();

            return new JsonResponse($result);
        }
        return new JsonResponse('Aucune ville trouvée');
    }

    #[Security("is_granted('ROLE_USER')")]
    #[Route('/api/get/booking/', name: 'api_calendar')]
    public function getCalendarBooking(BookingRepository $bookingRepository)
    {
        $bookings = $bookingRepository->findBy(['user' => $this->getUser()]);
        $events = [];
        foreach ($bookings as $booking) {
            $bookingEvent = [];
            $bookingEvent['title'] = $booking->getLocation()->getName();
            $bookingEvent['start'] = $booking->getStartAtEnFormat();
            $bookingEvent['end'] = $booking->getEndAtEnFormat();
            $events[] = $bookingEvent;
        }

        return new JsonResponse($events);
    }
}
