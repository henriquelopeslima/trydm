<?php

namespace App\Controller\Api;

use DateTime;
use Exception;
use App\Entity\Event;
use App\Entity\Lecture;
use App\Services\LectureService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("api/lecture", name="lecture")
 */
class LectureController extends AbstractController
{

    private $lectureService;

    public function __construct(LectureService $lectureService)
    {
        $this->lectureService = $lectureService;
    }

    /**
     * @Route("/", name="_get_all", methods={"GET"})
     * @return Response
     */
    public function index(): Response
    {
        return $this->json($this->lectureService->findAll());
    }

    /**
     * @Route("/{id}", name="_get_by_id", methods={"GET"})
     * @param int $id
     * @return string|JsonResponse
     */
    public function getById(int $id)
    {
        $lecture = $this->lectureService->getById($id);
        if($lecture == null){
            return  $this->response([
                'status' => 404,
                'message' => "Lecture not found",
            ]);
        }
        return $this->response([
            'status' => 200,
            'lecture' => $lecture,
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

            $lecture = new Lecture();
            $lecture->setTitle($request->get('title') ?? "");
            $lecture->setDescription($request->get('description') ?? "");
            $lecture->setDate(DateTime::createFromFormat('Y-m-d', $request->get('date')));
            $lecture->setHourBegin(DateTime::createFromFormat('h:m', $request->get('hour_begin')));
            $lecture->setHourEnd(DateTime::createFromFormat('h:m', $request->get('hour_end')));
            $lecture->setSpeaker($request->get('speaker') ?? "");

            $em = $this->getDoctrine()->getManager();
            $event = $em->find(Event::class, ["id" => $request->get("event_id")]);

            if ($event instanceof Event) {
                $lecture->setEvent($event);
            }

            $errors = $validator->validate($lecture);

            if(count($errors) > 0){
                return $this->json($errors, 400);
            }

            $this->lectureService->save($lecture);

            $data = [
                'status' => 200,
                'success' => "Lecture added successfully",
                'event' => $lecture
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
            $lecture = $this->lectureService->getById($id);
            $request = $this->transformJsonBody($request);

            if($request->get('title')){
                $lecture->setTitle($request->get('title') ?? "");
            }
            if($request->request->get('description')){
                $lecture->setDescription($request->get('description') ?? "");
            }
            if($request->request->get('date')){
                $lecture->setDate(DateTime::createFromFormat('Y-m-d', $request->get('date')));
            }
            if($request->request->get('hour_begin')){
                $lecture->setHourBegin(DateTime::createFromFormat('h:m', $request->get('hour_begin')));
            }
            if($request->request->get('hour_end')){
                $lecture->setHourEnd(DateTime::createFromFormat('h:m', $request->get('hour_end')));
            }
            if($request->request->get('speaker')){
                $lecture->setSpeaker($request->get('speaker') ?? "");
            }
            if($request->request->get('event_id')){
                $em = $this->getDoctrine()->getManager();
                $event = $em->find(Event::class, ["id" => $request->get("event_id")]);

                if ($event instanceof Event) {
                    $lecture->setEvent($event);
                }
            }

            $errors = $validator->validate($lecture);

            if(count($errors) > 0){
                return $this->json($errors, 400);
            }

            $this->lectureService->save($lecture);

            $data = [
                'status' => 200,
                'success' => "Lecture updated with success",
                'lecture' => $lecture
            ];
            return $this->response($data);

        }catch (Exception $e){
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
        if (!empty($lecture = $this->lectureService->delete($id))) {
            return $this->json(["removed" => $lecture], 200);
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
