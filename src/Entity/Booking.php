<?php

namespace App\Entity;

use App\Repository\BookingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $startDateAt = null;

    #[ORM\Column]
    private ?\DateTime $endDateAt = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column]
    private ?int $quantityTraveller = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $totalPrice = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'booking')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Location $location = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDateAt(): ?string
    {
        return $this->startDateAt->format('d-m-Y');
    }

    public function getStartAtEnFormat(): ?string
    {
        return $this->startDateAt->format('Y-m-d');
    }
    public function getEndAtEnFormat(): ?string
    {
        return $this->endDateAt->format('Y-m-d');
    }

    public function setStartDateAt(\DateTime $startDateAt): self
    {
        $this->startDateAt = $startDateAt;

        return $this;
    }

    public function getEndDateAt(): ?string
    {
        return $this->endDateAt->format('d-m-Y');
    }

    public function setEndDateAt(\DateTime $endDateAt): self
    {
        $this->endDateAt = $endDateAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getQuantityTraveller(): ?int
    {
        return $this->quantityTraveller;
    }

    public function setQuantityTraveller(int $quantityTraveller): self
    {
        $this->quantityTraveller = $quantityTraveller;

        return $this;
    }

    public function getTotalPrice(): ?string
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(string $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
