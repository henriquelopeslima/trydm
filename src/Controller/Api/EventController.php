<?php

namespace App\Controller\Api;

use App\Entity\Event;
use App\Services\EventService;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
     * @Route("/{id}", name="_get_by_id", methods={"GET"})
     * @param int $id
     * @return string|JsonResponse
     */
    public function getById(int $id)
    {
        $event = $this->eventService->getById($id);
        if($event == null){
            return  $this->response([
                'status' => 404,
                'message' => "Event not found",
            ]);
        }
        return $this->response([
            'status' => 200,
            'event' => $event,
        ]);
    }

    /**
     * @Route("/create", name="_create", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        try{
            $request = $this->transformJsonBody($request);

            $event = new Event();

            $event->setTitle($request->get('title') ?? "");
            $event->setDescription($request->get('description') ?? "");
            $event->setDateBegin(DateTime::createFromFormat('Y-m-d', $request->get('date_begin')));
            $event->setDateEnd(DateTime::createFromFormat('Y-m-d', $request->get('date_end')));

            $errors = $validator->validate($event);

            if(count($errors) > 0){
                return $this->json($errors, 400);
            }

            $this->eventService->save($event);

            $data = [
                'status' => 200,
                'success' => "Event added successfully",
                'event' => $event
            ];

            return $this->response($data);

        }catch (Exception $e){
            $data = [
                'status' => 422,
                'errors' => "Data no valid",
                'Exception' => $e->getMessage() . ' - ' . $e->getCode()
            ];
            return $this->response($data, 422);
        }

    }

    /**
     * @Route("/update/{id}", name="_update", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {
        try{
            $event = $this->eventService->getById($id);

            $request = $this->transformJsonBody($request);

            if($request->get('title')){
                $event->setTitle($request->get('title') ?? "");
            }
            if($request->request->get('description')){
                $event->setDescription($request->get('description') ?? "");
            }
            if($request->request->get('date_begin')){
                $event->setDateBegin(DateTime::createFromFormat('Y-m-d', $request->get('date_begin')));
            }
            if($request->request->get('date_end')){
                $event->setDateEnd(DateTime::createFromFormat('Y-m-d', $request->get('date_end')));
            }

            $errors = $validator->validate($event);

            if(count($errors) > 0){
                return $this->json($errors, 400);
            }

            $this->eventService->save($event);

            $data = [
                'status' => 200,
                'success' => "Event updated with success",
                'event' => $event
            ];
            return $this->response($data);

        }catch (\Exception $e){
            $data = [
                'status' => 422,
                'errors' => "Invalid",
                'Exception' => $e->getMessage() . ' - ' . $e->getCode()
            ];
            return $this->response($data, 422);
        }
    }

    /**
     * @Route("/delete/{id}", name="_delete", methods={"DELETE"}, requirements={"id":"\d+"})
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        if (!empty($event = $this->eventService->delete($id))) {
            return $this->json(["removed" => $event], 200);
        }
        return $this->json(["message" => "Not found by id $id"], 404);
    }

    /**
     * Returns a JSON response
     *
     * @param array $data
     * @param int $status
     * @param array $headers
     * @return JsonResponse
     */
    public function response(array $data, $status = 200, $headers = []): JsonResponse
    {
        return new JsonResponse($data, $status, $headers);
    }

    protected function transformJsonBody(Request $request): Request
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);

        return $request;
    }
}
