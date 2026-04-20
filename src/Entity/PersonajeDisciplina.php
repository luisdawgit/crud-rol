<?php

namespace App\Entity;

use App\Repository\PersonajeDisciplinaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonajeDisciplinaRepository::class)]
class PersonajeDisciplina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $nivel = null;

    #[ORM\ManyToOne(inversedBy: 'personajeDisciplinas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Disciplina $disciplina = null;

    #[ORM\ManyToOne(inversedBy: 'personajeDisciplinas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Personaje $personaje = null;

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

    public function getDisciplina(): ?Disciplina
    {
        return $this->disciplina;
    }

    public function setDisciplina(?Disciplina $disciplina): static
    {
        $this->disciplina = $disciplina;

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
}
