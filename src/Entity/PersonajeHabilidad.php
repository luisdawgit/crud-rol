<?php

namespace App\Entity;

use App\Repository\PersonajeHabilidadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonajeHabilidadRepository::class)]
class PersonajeHabilidad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nivel = null;

    #[ORM\ManyToOne(inversedBy: 'personajeHabilidades')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personaje $personaje = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Habilidad $habilidad = null;


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


    public function getHabilidad(): ?Habilidad
    {
        return $this->habilidad;
    }

    public function setHabilidad(?Habilidad $habilidad): static
    {
        $this->habilidad = $habilidad;

        return $this;
    }

}