<?php

namespace App\Entity;

use App\Repository\ClanDisciplinaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClanDisciplinaRepository::class)]
class ClanDisciplina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'clanDisciplinas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clan $clan = null;

    #[ORM\ManyToOne(inversedBy: 'clanDisciplinas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Disciplina $disciplina = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClan(): ?Clan
    {
        return $this->clan;
    }

    public function setClan(?Clan $clan): static
    {
        $this->clan = $clan;

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
}
