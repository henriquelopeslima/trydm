<?php

namespace App\DataFixtures;

use App\Entity\Event;
use App\Entity\Lecture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $data = new Data();
        $events = [];

        $events_local = $data->events();
        $lectures_local = $data->lectures();
        $speaker_local = $data->speaker();

        foreach ($events_local as $local) {
            $event = new Event();
            $event->setTitle($local["title"]);
            $event->setDescription($local["description"]);
            $event->setDateBegin(new \DateTime($local["data_begin"]));
            $event->setDateEnd(new \DateTime($local["data_end"]));
            $manager->persist($event);
            array_push($events, $event);
        }

        foreach ($lectures_local as $local) {
            $lecture = new Lecture();
            $lecture->setTitle($local["title"]);
            $lecture->setDescription($local["description"]);
            $lecture->setDate(new \DateTime($local["date"]));
            $lecture->setHourBegin(new \DateTime($local["hour_begin"]));
            $lecture->setHourEnd(new \DateTime($local["hour_end"]));
            $lecture->setEvent($events[$local["event_key"]]);
            $lecture->setSpeaker($speaker_local[(random_int(0,4))]);
            $manager->persist($lecture);
        }

        $manager->flush();
    }
}
