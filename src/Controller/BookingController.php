<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Location;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    #[Route('/my/bookings', name: 'app_my_bookings')]
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    #[Route('/my/bookings/calendar', name: 'app_my_bookings_calendar')]
    public function calendar(BookingRepository $bookingRepository): Response
    {

//        $bookings = $bookingRepository->findBy(['user' => $this->getUser()]);
//        $events = [];
//        foreach ($bookings as $booking) {
//            $bookingEvent = [];
//            $bookingEvent['title'] = $booking->getLocation()->getName();
//            $bookingEvent['start'] = $booking->getStartDateAt();
//            $bookingEvent['end'] = $booking->getEndDateAt();
//            $events[] = $bookingEvent;
//        }

        return $this->render('booking/calendar.html.twig', [
//            'events' => new JsonResponse($events),
            'bookings' => $bookingRepository->findBy(['user' => $this->getUser()]),
        ]);
    }

    #[Route('/booking/new/location/{id}', name: 'app_book_location', methods: ['GET', 'POST'])]
    #[Security("is_granted('ROLE_USER')")]
    public function bookLocation(Request $request, Location $location, EntityManagerInterface $entityManager): Response
    {
        $booking = new Booking();
        $dateRange = explode(' - ', $request->get('dateRange'));
        $start = DateTime::createFromFormat('d/m/Y', $dateRange[0]);
        $end   = DateTime::createFromFormat('d/m/Y', $dateRange[1]);

        $difference = $end->diff($start);
        $nbrOfNights = (int)$difference->format("%a");


        $booking
            ->setQuantityTraveller($request->get('travellerNumber'))
            ->setLocation($location)
            ->setUser($this->getUser())
            ->setTotalPrice($location->getPriceOneNight() * $nbrOfNights)
            ->setStartDateAt($start)
            ->setEndDateAt($end)
            ->setCreatedAt(new DateTime());

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $booking->setStartDateAt(DateTime::createFromFormat('d/m/Y', $dateRange[0]));
            $booking->setEndDateAt(DateTime::createFromFormat('d/m/Y', $dateRange[1]));

            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('app_my_bookings');
        }

        return $this->render('booking/form.html.twig', [
            'location' => $location,
            'form' => $form
        ]);
    }
}
