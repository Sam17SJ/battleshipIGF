<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PosicionRepository")
 */
class Posicion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $x;

    /**
     * @ORM\Column(type="smallint")
     */
    private $y;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getX(): ?string
    {
        return $this->x;
    }

    public function setX(string $x): self
    {
        $this->x = $x;

        return $this;
    }

    public function getY(): ?int
    {
        return $this->y;
    }

    public function setY(int $y): self
    {
        $this->y = $y;

        return $this;
    }
}
