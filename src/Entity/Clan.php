<?php

namespace App\Entity;

use App\Repository\ClanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClanRepository::class)]
class Clan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'clan', targetEntity: ClanDisciplina::class)]
    private Collection $clanDisciplinas;

    #[ORM\OneToMany(mappedBy: 'clan', targetEntity: Personaje::class)]
    private Collection $personajes;

    public function __construct()
    {
        $this->clanDisciplinas = new ArrayCollection();
        $this->personajes = new ArrayCollection();
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
            $clanDisciplina->setClan($this);
        }

        return $this;
    }

    public function removeClanDisciplina(ClanDisciplina $clanDisciplina): static
    {
        if ($this->clanDisciplinas->removeElement($clanDisciplina)) {
            // set the owning side to null (unless already changed)
            if ($clanDisciplina->getClan() === $this) {
                $clanDisciplina->setClan(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Personaje>
     */
    public function getPersonajes(): Collection
    {
        return $this->personajes;
    }

    public function addPersonaje(Personaje $personaje): static
    {
        if (!$this->personajes->contains($personaje)) {
            $this->personajes->add($personaje);
            $personaje->setClan($this);
        }

        return $this;
    }

    public function removePersonaje(Personaje $personaje): static
    {
        if ($this->personajes->removeElement($personaje)) {
            // set the owning side to null (unless already changed)
            if ($personaje->getClan() === $this) {
                $personaje->setClan(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getNombre();
    }

}