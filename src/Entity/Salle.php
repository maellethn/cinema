<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalleRepository")
 */
class Salle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sceance", mappedBy="salle")
     */
    private $sceance;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Film", mappedBy="salle")
     */
    private $films;

    public function __construct()
    {
        $this->sceance = new ArrayCollection();
        $this->films = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection|Sceance[]
     */
    public function getSceance(): Collection
    {
        return $this->sceance;
    }

    public function addSceance(Sceance $sceance): self
    {
        if (!$this->sceance->contains($sceance)) {
            $this->sceance[] = $sceance;
            $sceance->setSalle($this);
        }

        return $this;
    }

    public function removeSceance(Sceance $sceance): self
    {
        if ($this->sceance->contains($sceance)) {
            $this->sceance->removeElement($sceance);
            // set the owning side to null (unless already changed)
            if ($sceance->getSalle() === $this) {
                $sceance->setSalle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Film[]
     */
    public function getFilms(): Collection
    {
        return $this->films;
    }

    public function addFilm(Film $film): self
    {
        if (!$this->films->contains($film)) {
            $this->films[] = $film;
            $film->addSalle($this);
        }

        return $this;
    }

    public function removeFilm(Film $film): self
    {
        if ($this->films->contains($film)) {
            $this->films->removeElement($film);
            $film->removeSalle($this);
        }

        return $this;
    }
}
