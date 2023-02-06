<?php

namespace App\Entity;

use App\Repository\BoatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoatRepository::class)]
class Boat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $roofHeight = null;

    #[ORM\Column]
    private ?bool $motor = null;

    #[ORM\Column]
    private ?bool $isMoving = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoofHeight(): ?float
    {
        return $this->roofHeight;
    }

    public function setRoofHeight(?float $roofHeight): self
    {
        $this->roofHeight = $roofHeight;

        return $this;
    }

    public function isMotor(): ?bool
    {
        return $this->motor;
    }

    public function setMotor(bool $motor): self
    {
        $this->motor = $motor;

        return $this;
    }

    public function isIsMoving(): ?bool
    {
        return $this->isMoving;
    }

    public function setIsMoving(bool $isMoving): self
    {
        $this->isMoving = $isMoving;

        return $this;
    }
}
