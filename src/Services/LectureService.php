<?php

namespace App\Services;

use App\Entity\Lecture;
use App\Repository\LectureRepository;

class LectureService
{
    private $repository;

    public function __construct(LectureRepository $lectureRepository)
    {
        $this->repository = $lectureRepository;
    }

    public function save(Lecture $lecture){
        $this->repository->save($lecture);
    }

    public function delete(int $id): ?Lecture
    {
        $lecture = $this->repository->findOneBy(["id"=>$id]);
        if (!empty($lecture) ) {
            $this->repository->delete($lecture);
        }
        return $lecture;
    }

    public function update(int $id): ?Lecture
    {
        $lecture = $this->repository->findOneBy(["id"=>$id]);
        if (!empty($lecture) ) {
            $this->repository->delete($lecture);
        }
        return $lecture;
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function getById($id): ?Lecture
    {
        return $this->repository->findOneBy(['id' => $id]);
    }
}