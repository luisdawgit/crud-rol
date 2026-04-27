<?php

namespace App\Entity;

use App\Repository\DisciplinaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DisciplinaRepository::class)]
class Disciplina
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'disciplina', targetEntity: ClanDisciplina::class)]
    private Collection $clanDisciplinas;

    #[ORM\OneToMany(mappedBy: 'disciplina', targetEntity: PersonajeDisciplina::class)]
    private Collection $personajeDisciplinas;

    public function __construct()
    {
        $this->clanDisciplinas = new ArrayCollection();
        $this->personajeDisciplinas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, ClanDisciplina>
     */
    public function getClanDisciplinas(): Collection
    {
        return $this->clanDisciplinas;
    }

    public function addClanDisciplina(ClanDisciplina $clanDisciplina): static
    {
        if (!$this->clanDisciplinas->contains($clanDisciplina)) {
            $this->clanDisciplinas->add($clanDisciplina);
            $clanDisciplina->setDisciplina($this);
        }

        return $this;
    }

    public function removeClanDisciplina(ClanDisciplina $clanDisciplina): static
    {
        if ($this->clanDisciplinas->removeElement($clanDisciplina)) {
            // set the owning side to null (unless already changed)
            if ($clanDisciplina->getDisciplina() === $this) {
                $clanDisciplina->setDisciplina(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonajeDisciplina>
     */
    public function getPersonajeDisciplinas(): Collection
    {
        return $this->personajeDisciplinas;
    }

    public function addPersonajeDisciplina(PersonajeDisciplina $personajeDisciplina): static
    {
        if (!$this->personajeDisciplinas->contains($personajeDisciplina)) {
            $this->personajeDisciplinas->add($personajeDisciplina);
            $personajeDisciplina->setDisciplina($this);
        }

        return $this;
    }

    public function removePersonajeDisciplina(PersonajeDisciplina $personajeDisciplina): static
    {
        if ($this->personajeDisciplinas->removeElement($personajeDisciplina)) {
            // set the owning side to null (unless already changed)
            if ($personajeDisciplina->getDisciplina() === $this) {
                $personajeDisciplina->setDisciplina(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNombre();
    }
 
    /*
    public function __toString(): string
    {
        return $this->nombre ?? '';
    }
    */

}