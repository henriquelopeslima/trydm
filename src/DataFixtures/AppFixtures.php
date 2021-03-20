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
        $events = [];

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
            ],
            "2" => [
                "title" => "Microsoft Ignite",
                "description" => "Feito de desenvolvedor para desenvolvedor",
                "data_begin" => date('Y-m-d H:i:s'),
                "data_end" => date('Y-m-d H:i:s'),
            ],
            "3" => [
                "title" => "HackerSec",
                "description" => "A HackerSec é uma empresa de inovação em cibersegurança.",
                "data_begin" => date('Y-m-d H:i:s'),
                "data_end" => date('Y-m-d H:i:s'),
            ],
            "4" => [
                "title" => "ValeWeb",
                "description" => "Feito na Universidade Federal de Russa, para todos os desenvolvedores Web",
                "data_begin" => date('Y-m-d H:i:s'),
                "data_end" => date('Y-m-d H:i:s'),
            ],
            "5" => [
                "title" => "MILSET BRASIL",
                "description" => "Expo nacional MILSET Brasil",
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
                "event_key" => "0",
            ],
            "1" => [
                "title" => "Filas e Mensageria: Da teoria à prática sem complicação.",
                "description" => "Muito tem-se falado sobre o desenvolvimento utilizando arquitetura de Microsserviços.",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "0",
            ],
            "2" => [
                "title" => "Aprendendo Scrum na prática com blocos de montar",
                "description" => "Scrum é um framework de metodologia ágil bastante popular utilizado para orientar o desenvolvimento de software.",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "0",
            ],
            "3" => [
                "title" => "Web scraping com PHP: automatize coleta de dados da web",
                "description" => "Necessita coletar dados da web? Conheça como esta técnica funciona, suas variantes e as ferramentas mais...",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "0",
            ],
            "4" => [
                "title" => "Qualidade de Código",
                "description" => "Um resumo prático do que todo dev precisa saber",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "0",
            ],
            "5" => [
                "title" => "Docker na Prática sem arrudeio",
                "description" => "Certificado ZCE PHP, Autor do livro Aprendendo Docker, do básico à orquestração de contêineres. ",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "1",
            ],
            "6" => [
                "title" => "Segurança na Prática",
                "description" => "Hackeando sua Aplicação PHP",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "2",
            ],
            "7" => [
                "title" => "Cubit, Freezed, Dartz a tríade perfeita!!! ",
                "description" => "Trazendo o beneficio da programação funcional, com o poder do BLoC simplificando.",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "3",
            ],
            "8" => [
                "title" => "Impulsionando a integridade da sua UI com Testes de Widget. ",
                "description" => "A maior quantidade de código de uma aplicação mobile se concentra em telas, testes de Widget.",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "3",
            ],
            "9" => [
                "title" => "Automation tests for Flutter ",
                "description" => "Writing automated tests can be a challenging task by the particularity of this kind of coding.",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "3",
            ],
            "10" => [
                "title" => "Flutter vai dominar o mundo? ",
                "description" => "Maybe my friend... Maybe",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "4",
            ],
            "11" => [
                "title" => "Keynote",
                "description" => "Como Magalu escalou seu time de tecnologia de 2 para 1000+ CODERS",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "4",
            ],
            "12" => [
                "title" => " Developer Experience no Nubank",
                "description" => "Você já ouviu falar sobre Developer Experience? Entenda como provemos...",
                "date" => date('Y-m-d'),
                "hour_begin" => date('H:i'),
                "hour_end" => date('H:i'),
                "event_key" => "4",
            ],
        ];

        $speaker_local = [
            "0" => "Alessandro Feitoza",
            "1" => "Fr Daniel Lima",
            "2" => "Maria Clara",
            "3" => "Nicolas Grekas",
            "4" => "Cyrille Grandval"
        ];

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
