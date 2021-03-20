<?php

namespace App\Entity;

use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=EventRepository::class)
 */
class Event implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Minino eu preciso do título.")
     * @Assert\Length(min=5)
     */
    private $title;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="É requirido a data de início.")
     */
    private $date_begin;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="É requirido a data final.")
     */
    private $date_end;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="É requirido a descrição.")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Lecture::class, mappedBy="event", orphanRemoval=true)
     */
    private $lectures;

    public function __construct()
    {
        $this->lectures = new ArrayCollection();
    }

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

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->date_begin;
    }

    public function setDateBegin(\DateTimeInterface $date_begin): self
    {
        $this->date_begin = $date_begin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Lecture[]
     */
    public function getLectures(): Collection
    {
        return $this->lectures;
    }

    public function addLecture(Lecture $lecture): self
    {
        if (!$this->lectures->contains($lecture)) {
            $this->lectures[] = $lecture;
            $lecture->setEvent($this);
        }

        return $this;
    }

    public function removeLecture(Lecture $lecture): self
    {
        if ($this->lectures->removeElement($lecture)) {
            // set the owning side to null (unless already changed)
            if ($lecture->getEvent() === $this) {
                $lecture->setEvent(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->title;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'date_begin' => $this->getDateBegin()->format("Y-m-d h:i:s"),
            'date_end' => $this->getDateEnd()->format("Y-m-d h:i:s")
        ];
    }
}
