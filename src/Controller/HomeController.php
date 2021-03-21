<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Lecture;
use App\Form\LectureType;
use App\Repository\EventRepository;
use App\Repository\LectureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Exception;

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
     * @return string|Response
     */
    public function index(EventRepository $eventRepository)
    {
        try {
            return new Response($this->twig->render('index.html.twig', [
                'events' => $eventRepository->findAll(),
            ]));
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e->getMessage() . $e->getCode();
        }
    }

    /**
     * @Route("/evento/{id}", name="event")
     * @param Request $request
     * @param Event $event
     * @param LectureRepository $lectureRepository
     * @return string|Response
     * @throws Exception
     */
    public function show(Request $request, Event $event, LectureRepository $lectureRepository)
    {
        $lecture = new Lecture();
        $form = $this->createForm(LectureType::class, $lecture);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lecture->setEvent($event);
            $lectureRepository->save($lecture);
            return $this->redirectToRoute('evento', ['id' => $event->getId()]);
        }

        try {
            return new Response($this->twig->render('show.html.twig', [
                'event' => $event,
                'lectures' => $lectureRepository->findBy(['event' => $event]),
                'lecture_form' => $form->createView()
            ]));
        } catch (LoaderError | RuntimeError | SyntaxError $e) {
            return $e->getMessage() . $e->getCode();
        }
    }
}
