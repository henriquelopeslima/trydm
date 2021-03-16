<?php


namespace App\Services;


use App\Entity\Event;
use App\Repository\EventRepository;

class EventService
{
    private $repository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->repository = $eventRepository;
    }

    public function save(Event $event){
        $this->repository->save($event);
    }

    public function delete(int $id){
        $event = $this->repository->findBy(["id"=>$id]);
        if (!empty($event) ) {
            /** @var Event $event */
            $this->repository->delete($event);
        }
        return $event;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }
}