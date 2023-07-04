<?php

namespace App\Controller;

use App\Entity\Booking;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/bookings")
 */
class BookingController extends AbstractController
{
    /**
     * @Route("", name="booking_list", methods={"GET"})
     */
    public function index(): Response
    {
        $bookings = $this->getDoctrine()->getRepository(Booking::class)->findAll();

        return $this->json($bookings);
    }

    /**
     * @Route("/{id}", name="booking_show", methods={"GET"})
     */
    public function show(Booking $booking): Response
    {
        return $this->json($booking);
    }

    /**
     * @Route("", name="booking_create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $booking = new Booking();
        $booking->setStatus($data['status'])
            ->setCreatedAt(new \DateTimeImmutable())
            ->setDescription($data['description']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($booking);
        $entityManager->flush();

        return $this->json($booking, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", name="booking_update", methods={"PUT"})
     */
    public function update(Request $request, Booking $booking): Response
    {
        $data = json_decode($request->getContent(), true);

        $booking->setStatus($data['status'])
            ->setDescription($data['description']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json($booking);
    }

    /**
     * @Route("/{id}", name="booking_delete", methods={"DELETE"})
     */
    public function delete(Booking $booking): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($booking);
        $entityManager->flush();

        return new Response(null, Response::HTTP_NO_CONTENT);
    }
}
