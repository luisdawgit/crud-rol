<?php

namespace App\Entity;

use App\Repository\PersonajeVirtudRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonajeVirtudRepository::class)]
class PersonajeVirtud
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nivel = null;

    #[ORM\ManyToOne(inversedBy: 'personajeVirtudes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personaje $personaje = null;

    #[ORM\ManyToOne]//--borrar inversed?
    #[ORM\JoinColumn(nullable: false)]
    private ?Virtud $virtud = null;

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

    public function getVirtud(): ?Virtud
    {
        return $this->virtud;
    }

    public function setVirtud(?Virtud $virtud): static
    {
        $this->virtud = $virtud;

        return $this;
    }
}