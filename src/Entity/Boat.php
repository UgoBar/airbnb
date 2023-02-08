<?php

namespace App\Entity;

use App\Repository\BoatRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoatRepository::class)]
class Boat extends Location
{

    #[ORM\Column(nullable: true)]
    private ?float $roofHeight = null;

    #[ORM\Column]
    private ?bool $motor = null;

    #[ORM\Column]
    private ?bool $isMoving = null;

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
