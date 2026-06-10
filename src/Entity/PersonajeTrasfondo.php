<?php

namespace App\Entity;

use App\Repository\PersonajeTrasfondoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonajeTrasfondoRepository::class)]
class PersonajeTrasfondo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nivel = null;

    #[ORM\ManyToOne(inversedBy: 'personajeTrasfondos')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Personaje $personaje = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Trasfondo $trasfondo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNivel(): ?int
    {
        return $this->nivel;
    }

    public function setNivel(int $nivel): static
    {
        $this->nivel = $nivel;

        return $this;
    }

    public function getPersonaje(): ?Personaje
    {
        return $this->personaje;
    }

    public function setPersonaje(?Personaje $personaje): static
    {
        $this->personaje = $personaje;

        return $this;
    }

    public function getTrasfondo(): ?Trasfondo
    {
        return $this->trasfondo;
    }

    public function setTrasfondo(?Trasfondo $trasfondo): static
    {
        $this->trasfondo = $trasfondo;

        return $this;
    }
}