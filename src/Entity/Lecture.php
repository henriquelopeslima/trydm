<?php

namespace App\Entity;

use App\Repository\LectureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LectureRepository::class)
 */
class Lecture implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Homi eu preciso do título.")
     */
    private $title;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Minino eu preciso da data.")
     */
    private $date;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank(message="É preciso da hora de inicio.")
     */
    private $hour_begin;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank(message="É preciso da hora final.")
     */
    private $hour_end;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="A descrição é requerida.")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Event::class, inversedBy="lectures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="O palestrante é requerido.")
     */
    private $speaker;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHourBegin(): ?\DateTimeInterface
    {
        return $this->hour_begin;
    }

    public function setHourBegin(\DateTimeInterface $hour_begin): self
    {
        $this->hour_begin = $hour_begin;

        return $this;
    }

    public function getHourEnd(): ?\DateTimeInterface
    {
        return $this->hour_end;
    }

    public function setHourEnd(\DateTimeInterface $hour_end): self
    {
        $this->hour_end = $hour_end;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function getSpeaker(): ?string
    {
        return $this->speaker;
    }

    public function setSpeaker(?string $speaker): self
    {
        $this->speaker = $speaker;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'date' => $this->getDate()->format("Y-m-d"),
            'hour_begin' => $this->getHourBegin()->format("h:i"),
            'hour_end' => $this->getHourEnd()->format("h:i"),
            'speaker' => $this->getSpeaker(),
            'event_id' => $this->getEvent()->getId()
        ];
    }
}
