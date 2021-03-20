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

    public function delete(int $id): ?Event
    {
        $event = $this->repository->findOneBy(["id"=>$id]);
        if (!empty($event) ) {
            $this->repository->delete($event);
        }
        return $event;
    }

    public function update(int $id): ?Event
    {
        $event = $this->repository->findOneBy(["id"=>$id]);
        if (!empty($event) ) {
            $this->repository->delete($event);
        }
        return $event;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function getById($id): Event
    {
        return $this->repository->findOneBy(['id' => $id]);
    }
}