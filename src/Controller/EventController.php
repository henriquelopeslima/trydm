<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EventRepository;

use App\Repository\LectureRepository;
use Exception;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class EventController extends AbstractController
{
    /**
     * @Route("/", name="events")
     * @param Environment $twig
     * @param EventRepository $eventRepository
     * @return Exception|Response|LoaderError|RuntimeError|SyntaxError
     */
    public function index(Environment $twig, EventRepository $eventRepository)
    {
        try {
            return new Response($twig->render('event/index.html.twig', [
                'events' => $eventRepository->findAll()
            ]));
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e;
        }
    }

    /**
     * @Route("/event/{id}", name="event")
     * @param Environment $twig
     * @param Event $event
     * @param LectureRepository $lectureRepository
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function show(Environment $twig, Event $event, LectureRepository $lectureRepository): Response
    {

        return new Response($twig->render('event/show.html.twig', [
            'event' => $event,
            'lectures' => $lectureRepository->findBy(['event' => $event]),
        ]));
    }
}
