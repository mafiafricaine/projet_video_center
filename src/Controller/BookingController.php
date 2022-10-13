<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/booking")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("/", name="app_booking_index", methods={"GET"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        $events = $bookingRepository->findAll();
        $rdvs = [];
        foreach($events as $event){
            $rdvs = [
                'id'=> $event->getId(),
                'beginAt'=> $event->getBeginAt()->format('d/m/Y H:i'),
                'endAt'=> $event->getEndAt()->format('d/m/Y H:i'),
                'title'=> $event->getTitle(),

            ];
        }
        $data = json_encode($rdvs);
        return $this->render('booking/index.html.twig',compact ('data'));
    }

    /**
     * @Route("/new", name="app_booking_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BookingRepository $bookingRepository): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->add($booking, true);

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking/new.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_booking_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    {
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bookingRepository->add($booking, true);

            return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_booking_delete", methods={"POST"})
     */
    public function delete(Request $request, Booking $booking, BookingRepository $bookingRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $bookingRepository->remove($booking, true);
        }

        return $this->redirectToRoute('app_booking_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/calendar/{id} ", name="app_booking_calendar", methods={"GET"})
     */
    public function calendar(BookingRepository $bookingRepository): Response
    {
        $events = $bookingRepository->findAll();
        $rdvs = [];
        foreach($events as $event){
            $rdvs = [
                'id'=> $event->getId(),
                'beginAt'=> $event->getBeginAt()->format('d/m/Y H:i'),
                'endAt'=> $event->getEndAt()->format('d/m/Y H:i'),
                'title'=> $event->getTitle(),

            ];
        }
        $data = json_encode($rdvs);
        return $this->render('booking/calendar.html.twig',compact ('data'));
    }
}
