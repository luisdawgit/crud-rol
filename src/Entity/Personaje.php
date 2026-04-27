<?php

namespace App\Entity;

use App\Repository\PersonajeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity(repositoryClass: PersonajeRepository::class)]
class Personaje
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $experiencia = null;

    #[ORM\Column(length: 40)]
    private ?string $nombre = null;

    #[ORM\ManyToOne(inversedBy: 'personajes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Clan $clan = null;

    #[ORM\ManyToOne(inversedBy: 'personajes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

  #[ORM\OneToMany(
    mappedBy: 'personaje',
    targetEntity: PersonajeDisciplina::class,
    orphanRemoval: true,
    cascade: ['remove']
)]
    private Collection $personajeDisciplinas;

    #[ORM\OneToMany(mappedBy: 'personaje', targetEntity: ExperienciaHistorial::class)]
    private Collection $experienciaHistorials;

    public function __construct()
    {
        $this->personajeDisciplinas = new ArrayCollection();
        $this->experienciaHistorials = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExperiencia(): ?int
    {
        return $this->experiencia;
    }

    public function setExperiencia(int $experiencia): static
    {
        $this->experiencia = $experiencia;

        return $this;
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

    public function getClan(): ?Clan
    {
        return $this->clan;
    }

    public function setClan(?Clan $clan): static
    {
        $this->clan = $clan;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

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
            $personajeDisciplina->setPersonaje($this);
        }

        return $this;
    }

    public function removePersonajeDisciplina(PersonajeDisciplina $personajeDisciplina): static
    {
        if ($this->personajeDisciplinas->removeElement($personajeDisciplina)) {
            // set the owning side to null (unless already changed)
            if ($personajeDisciplina->getPersonaje() === $this) {
                $personajeDisciplina->setPersonaje(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExperienciaHistorial>
     */
    public function getExperienciaHistorials(): Collection
    {
        return $this->experienciaHistorials;
    }

    public function addExperienciaHistorial(ExperienciaHistorial $experienciaHistorial): static
    {
        if (!$this->experienciaHistorials->contains($experienciaHistorial)) {
            $this->experienciaHistorials->add($experienciaHistorial);
            $experienciaHistorial->setPersonaje($this);
        }

        return $this;
    }

    public function removeExperienciaHistorial(ExperienciaHistorial $experienciaHistorial): static
    {
        if ($this->experienciaHistorials->removeElement($experienciaHistorial)) {
            // set the owning side to null (unless already changed)
            if ($experienciaHistorial->getPersonaje() === $this) {
                $experienciaHistorial->setPersonaje(null);
            }
        }

        return $this;
    }
}