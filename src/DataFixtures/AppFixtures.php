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
        $events_local = [
            "0" => [
                "title" => "Darkmira",
                "description" => "O evento imperdível sobre segurança e qualidade nos ecossistemas PHP",
                "data_begin" => date('Y-m-d H:i:s'),
                "data_end" => date('Y-m-d H:i:s'),
            ],
            "1" => [
                "title" => "FLISoL",
                "description" => "Festival Latino-americano de Instalação de Software Livre",
                "data_begin" => date('Y-m-d H:i:s'),
                "data_end" => date('Y-m-d H:i:s'),
            ]
        ];

        $lectures_local = [
            "0" => [
                "title" => "Symfony 5: A Trilha Rápida.",
                "description" => "Este treinamento é do livro Symfony 5: A Trilha Rápida, de Fabien Potencier.",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
            ],
            "1" => [
                "title" => "Filas e Mensageria: Da teoria à prática sem complicação.",
                "description" => "Muito tem-se falado sobre o desenvolvimento utilizando arquitetura de Microsserviços.",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
            ],
        ];

        $events = [];

        foreach ($events_local as $local) {
            $event = new Event();
            $event->setTitle($local["title"]);
            $event->setDescription($local["description"]);
            $event->setDateBegin(new \DateTime($local["data_begin"]));
            $event->setDateEnd(new \DateTime($local["data_end"]));
            $manager->persist($event);
            array_push($events, $event);
        }

        foreach ($lectures_local as $key => $local) {
            $lecture = new Lecture();
            $lecture->setTitle($local["title"]);
            $lecture->setDescription($local["description"]);
            $lecture->setDate(new \DateTime($local["date"]));
            $lecture->setHourBegin(new \DateTime($local["hour_begin"]));
            $lecture->setHourEnd(new \DateTime($local["hour_end"]));
            $lecture->setEvent($events[$key]);
            $manager->persist($lecture);
        }

        $manager->flush();
    }
}
