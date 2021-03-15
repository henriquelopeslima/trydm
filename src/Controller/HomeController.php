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

class HomeController extends AbstractController
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/", name="homepage")
     * @param EventRepository $eventRepository
     * @return Exception|Response|LoaderError|RuntimeError|SyntaxError
     */
    public function index(EventRepository $eventRepository)
    {
        try {
            return new Response($this->twig->render('index.html.twig', [
                'events' => $eventRepository->findAll(),
            ]));
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e;
        }
    }

    /**
     * @Route("/evento/{id}", name="event")
     * @param Event $event
     * @param LectureRepository $lectureRepository
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function show(Event $event, LectureRepository $lectureRepository): Response
    {

        return new Response($this->twig->render('show.html.twig', [
            'event' => $event,
            'lectures' => $lectureRepository->findBy(['event' => $event]),
        ]));
    }
}
