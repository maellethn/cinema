<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FilmRepository")
 */
class Film
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
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $affiche;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_sortie;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Realisateur", inversedBy="films")
     * @ORM\JoinColumn(nullable=false)
     */
    private $realisateur;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Acteur", inversedBy="films")
     */
    private $acteur;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categorie", inversedBy="films")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BandeAnnonce", mappedBy="film")
     */
    private $bande_annonce;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Photo", mappedBy="film")
     */
    private $photo;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Salle", inversedBy="films")
     */
    private $salle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commentaire", mappedBy="film")
     */
    private $commentaire;

    /**
     * @ORM\Column(type="integer")
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sceance", mappedBy="film")
     */
    private $sceance;

    public function __construct()
    {
        $this->acteur = new ArrayCollection();
        $this->categorie = new ArrayCollection();
        $this->bande_annonce = new ArrayCollection();
        $this->photo = new ArrayCollection();
        $this->salle = new ArrayCollection();
        $this->commentaire = new ArrayCollection();
        $this->sceance = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getAffiche(): ?string
    {
        return $this->affiche;
    }

    public function setAffiche(string $affiche): self
    {
        $this->affiche = $affiche;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateSortie(): ?\DateTimeInterface
    {
        return $this->date_sortie;
    }

    public function setDateSortie(\DateTimeInterface $date_sortie): self
    {
        $this->date_sortie = $date_sortie;

        return $this;
    }

    public function getRealisateur(): ?Realisateur
    {
        return $this->realisateur;
    }

    public function setRealisateur(?Realisateur $realisateur): self
    {
        $this->realisateur = $realisateur;

        return $this;
    }

    /**
     * @return Collection|Acteur[]
     */
    public function getActeur(): Collection
    {
        return $this->acteur;
    }

    public function addActeur(Acteur $acteur): self
    {
        if (!$this->acteur->contains($acteur)) {
            $this->acteur[] = $acteur;
        }

        return $this;
    }

    public function removeActeur(Acteur $acteur): self
    {
        if ($this->acteur->contains($acteur)) {
            $this->acteur->removeElement($acteur);
        }

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategorie(): Collection
    {
        return $this->categorie;
    }

    public function addCategorie(Categorie $categorie): self
    {
        if (!$this->categorie->contains($categorie)) {
            $this->categorie[] = $categorie;
        }

        return $this;
    }

    public function removeCategorie(Categorie $categorie): self
    {
        if ($this->categorie->contains($categorie)) {
            $this->categorie->removeElement($categorie);
        }

        return $this;
    }

    /**
     * @return Collection|BandeAnnonce[]
     */
    public function getBandeAnnonce(): Collection
    {
        return $this->bande_annonce;
    }

    public function addBandeAnnonce(BandeAnnonce $bandeAnnonce): self
    {
        if (!$this->bande_annonce->contains($bandeAnnonce)) {
            $this->bande_annonce[] = $bandeAnnonce;
            $bandeAnnonce->setFilm($this);
        }

        return $this;
    }

    public function removeBandeAnnonce(BandeAnnonce $bandeAnnonce): self
    {
        if ($this->bande_annonce->contains($bandeAnnonce)) {
            $this->bande_annonce->removeElement($bandeAnnonce);
            // set the owning side to null (unless already changed)
            if ($bandeAnnonce->getFilm() === $this) {
                $bandeAnnonce->setFilm(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhoto(): Collection
    {
        return $this->photo;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photo->contains($photo)) {
            $this->photo[] = $photo;
            $photo->setFilm($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photo->contains($photo)) {
            $this->photo->removeElement($photo);
            // set the owning side to null (unless already changed)
            if ($photo->getFilm() === $this) {
                $photo->setFilm(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Salle[]
     */
    public function getSalle(): Collection
    {
        return $this->salle;
    }

    public function addSalle(Salle $salle): self
    {
        if (!$this->salle->contains($salle)) {
            $this->salle[] = $salle;
        }

        return $this;
    }

    public function removeSalle(Salle $salle): self
    {
        if ($this->salle->contains($salle)) {
            $this->salle->removeElement($salle);
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaire(): Collection
    {
        return $this->commentaire;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaire->contains($commentaire)) {
            $this->commentaire[] = $commentaire;
            $commentaire->setFilm($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaire->contains($commentaire)) {
            $this->commentaire->removeElement($commentaire);
            // set the owning side to null (unless already changed)
            if ($commentaire->getFilm() === $this) {
                $commentaire->setFilm(null);
            }
        }

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

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
            $sceance->setFilm($this);
        }

        return $this;
    }

    public function removeSceance(Sceance $sceance): self
    {
        if ($this->sceance->contains($sceance)) {
            $this->sceance->removeElement($sceance);
            // set the owning side to null (unless already changed)
            if ($sceance->getFilm() === $this) {
                $sceance->setFilm(null);
            }
        }

        return $this;
    }
}
