<?php

namespace App\Entity;

use App\Repository\PersonajeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\OneToMany(mappedBy: 'personaje', targetEntity: PersonajeAtributo::class, orphanRemoval: true,
    cascade: ['remove'])]
    private Collection $personajeAtributos;

#[ORM\OneToMany(
    mappedBy: 'personaje',
    targetEntity: PersonajeHabilidad::class,
    orphanRemoval: true
)]
private Collection $personajeHabilidades;

#[ORM\OneToMany(mappedBy: 'personaje', targetEntity: PersonajeTrasfondo::class, orphanRemoval: true)]
private Collection $personajeTrasfondos;

#[ORM\OneToMany(mappedBy: 'personaje', targetEntity: PersonajeVirtud::class, orphanRemoval: true)]
private Collection $personajeVirtudes;

#[ORM\Column(length: 50)]
private ?string $naturaleza = null;

#[ORM\Column(length: 50)]
private ?string $conducta = null;

#[ORM\Column(length: 50)]
private ?string $concepto = null;




    public function __construct()
    {
        $this->personajeDisciplinas = new ArrayCollection();
        $this->experienciaHistorials = new ArrayCollection();
        $this->personajeAtributos = new ArrayCollection();
        $this->personajeHabilidades = new ArrayCollection();
        $this->personajeTrasfondos = new ArrayCollection();
        $this->personajeVirtudes = new ArrayCollection();
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
    public function getPersonajeHabilidades(): Collection
    {
        return $this->personajeHabilidades;
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

    /**
     * @return Collection<int, PersonajeAtributo>
     */
    public function getPersonajeAtributos(): Collection
    {
        return $this->personajeAtributos;
    }

    public function addPersonajeAtributo(PersonajeAtributo $personajeAtributo): static
    {
        if (!$this->personajeAtributos->contains($personajeAtributo)) {
            $this->personajeAtributos->add($personajeAtributo);
            $personajeAtributo->setPersonaje($this);
        }

        return $this;
    }

    public function removePersonajeAtributo(PersonajeAtributo $personajeAtributo): static
    {
        if ($this->personajeAtributos->removeElement($personajeAtributo)) {
            // set the owning side to null (unless already changed)
            if ($personajeAtributo->getPersonaje() === $this) {
                $personajeAtributo->setPersonaje(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonajeTrasfondo>
     */
    public function getPersonajeTrasfondos(): Collection
    {
        return $this->personajeTrasfondos;
    }

    public function addPersonajeTrasfondo(PersonajeTrasfondo $personajeTrasfondo): static
    {
        if (!$this->personajeTrasfondos->contains($personajeTrasfondo)) {
            $this->personajeTrasfondos->add($personajeTrasfondo);
            $personajeTrasfondo->setPersonaje($this);
        }

        return $this;
    }

    public function removePersonajeTrasfondo(PersonajeTrasfondo $personajeTrasfondo): static
    {
        if ($this->personajeTrasfondos->removeElement($personajeTrasfondo)) {
            // set the owning side to null (unless already changed)
            if ($personajeTrasfondo->getPersonaje() === $this) {
                $personajeTrasfondo->setPersonaje(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonajeVirtud>
     */
    public function getPersonajeVirtudes(): Collection
    {
        return $this->personajeVirtudes;
    }

    public function addPersonajeVirtude(PersonajeVirtud $personajeVirtude): static
    {
        if (!$this->personajeVirtudes->contains($personajeVirtude)) {
            $this->personajeVirtudes->add($personajeVirtude);
            $personajeVirtude->setPersonaje($this);
        }

        return $this;
    }

    public function removePersonajeVirtude(PersonajeVirtud $personajeVirtude): static
    {
        if ($this->personajeVirtudes->removeElement($personajeVirtude)) {
            // set the owning side to null (unless already changed)
            if ($personajeVirtude->getPersonaje() === $this) {
                $personajeVirtude->setPersonaje(null);
            }
        }

        return $this;
    }

    public function getNaturaleza(): ?string
    {
        return $this->naturaleza;
    }

    public function setNaturaleza(string $naturaleza): static
    {
        $this->naturaleza = $naturaleza;

        return $this;
    }

    public function getConducta(): ?string
    {
        return $this->conducta;
    }

    public function setConducta(string $conducta): static
    {
        $this->conducta = $conducta;

        return $this;
    }

    public function getConcepto(): ?string
    {
        return $this->concepto;
    }

    public function setConcepto(string $concepto): static
    {
        $this->concepto = $concepto;

        return $this;
    }
}