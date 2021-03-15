<?php

namespace App\Controller\Api;

use App\Entity\Event;
use App\Repository\EventRepository;
use App\Services\EventService;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("api/event", name="event")
 */
class EventController extends AbstractController
{

    private $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    /**
     * @Route("/", name="_get_all", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->json($this->eventService->findAll());
    }

    /**
     * @Route("/delete/{id}", name="_delete", methods={"DELETE"}, requirements={"id":"\d+"})
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        if(!empty($event = $this->eventService->delete($id))){
           return $this->json([ "removed" => $event ], 200);
        }
        return $this->json([ "message" => "Not found by id $id"], 404);
    }

    /**
     * @Route("/update/{id}", name="_update", methods={"PUT"})
     * @param Event $event
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function update(Event $event, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $event->setTitle($data['title']);

        // atualizando data da ultima atualização dessa entidade no banco
        // $event->setUpdatedAt(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")));

        // salvando as alterações no banco
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->flush();

        return $this->json($event);
    }

    /**
     * @Route("/create", name="_create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $event = new Event();
        $event->setTitle($data['title']);
        $event->setDescription($data['description']);
        $event
            ->setDateBegin(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
            ->setDateEnd(new \DateTime("now", new \DateTimeZone("America/Sao_Paulo")))
        ;

        // chamando orm para persistir os dados na tabela
        $doctrine = $this->getDoctrine()->getManager();
        $doctrine->persist($event);
        $doctrine->flush();

        return $this->json([
            'Evento' => $event
        ]);
    }
}
