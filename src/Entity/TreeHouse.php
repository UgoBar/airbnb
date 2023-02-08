<?php

namespace App\Entity;

use App\Repository\TreeHouseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TreeHouseRepository::class)]
class TreeHouse extends Location
{

    #[ORM\Column]
    private ?float $treeHeight = null;

    public function getTreeHeight(): ?float
    {
        return $this->treeHeight;
    }

    public function setTreeHeight(float $treeHeight): self
    {
        $this->treeHeight = $treeHeight;

        return $this;
    }
}
