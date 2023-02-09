<?php

namespace App\Entity;

use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $hasBathroom = null;

    #[ORM\Column]
    private ?bool $hasBalcony = null;

    #[ORM\OneToMany(mappedBy: 'room', targetEntity: RoomBed::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $roomBeds;

    #[ORM\ManyToOne(inversedBy: 'rooms')]
    private ?Location $location = null;

    public function __construct()
    {
        $this->roomBeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isHasBathroom(): ?bool
    {
        return $this->hasBathroom;
    }

    public function setHasBathroom(bool $hasBathroom): self
    {
        $this->hasBathroom = $hasBathroom;

        return $this;
    }

    public function isHasBalcony(): ?bool
    {
        return $this->hasBalcony;
    }

    public function setHasBalcony(bool $hasBalcony): self
    {
        $this->hasBalcony = $hasBalcony;

        return $this;
    }

    /**
     * @return Collection<int, RoomBed>
     */
    public function getRoomBeds(): Collection
    {
        return $this->roomBeds;
    }

    public function addRoomBed(RoomBed $roomBed): self
    {
        if (!$this->roomBeds->contains($roomBed)) {
            $this->roomBeds->add($roomBed);
            $roomBed->setRoom($this);
        }

        return $this;
    }

    public function removeRoomBed(RoomBed $roomBed): self
    {
        if ($this->roomBeds->removeElement($roomBed)) {
            // set the owning side to null (unless already changed)
            if ($roomBed->getRoom() === $this) {
                $roomBed->setRoom(null);
            }
        }

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }
}
