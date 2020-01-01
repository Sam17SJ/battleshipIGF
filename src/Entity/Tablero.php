<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TableroRepository")
 */
class Tablero
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $grid = [];

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGrid(): ?array
    {
        return $this->grid;
    }

    public function setGrid(?array $grid): self
    {
        $this->grid = $grid;

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
}
