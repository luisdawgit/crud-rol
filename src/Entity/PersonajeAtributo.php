<?php

namespace App\Entity;

use App\Repository\PersonajeAtributoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonajeAtributoRepository::class)]
class PersonajeAtributo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nivel = null;

    #[ORM\ManyToOne(inversedBy: 'personajeAtributos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personaje $personaje = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Atributo $atributo = null;


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

    public function getAtributo(): ?Atributo
    {
        return $this->atributo;
    }

    public function setAtributo(?Atributo $atributo): static
    {
        $this->atributo = $atributo;

        return $this;
    }

}