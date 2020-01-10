<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JuegoRepository")
 */
class Juego
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $turnos;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ganador;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $jugador1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $jugador2;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTurnos(): ?int
    {
        return $this->turnos;
    }

    public function setTurnos(?int $turnos): self
    {
        $this->turnos = $turnos;

        return $this;
    }

    public function getGanador(): ?string
    {
        return $this->ganador;
    }

    public function setGanador(?string $ganador): self
    {
        $this->ganador = $ganador;

        return $this;
    }

    public function getJugador1(): ?User
    {
        return $this->jugador1;
    }

    public function setJugador1(User $jugador1): self
    {
        $this->jugador1 = $jugador1;

        return $this;
    }

    public function getJugador2(): ?User
    {
        return $this->jugador2;
    }

    public function setJugador2(?User $jugador2): self
    {
        $this->jugador2 = $jugador2;

        return $this;
    }
}
