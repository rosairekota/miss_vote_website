<?php

namespace App\Entity;

use App\Repository\CompetitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetitionRepository::class)
 */
class Competition
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
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_competition;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu;

    /**
     * @ORM\OneToMany(targetEntity=Theme::class, mappedBy="competition", orphanRemoval=true, cascade={"persist"},fetch="EAGER")
     */
    private $themes;

    /**
     * @ORM\OneToMany(targetEntity=Cote::class, mappedBy="competition", orphanRemoval=true, cascade={"persist"},fetch="EAGER")
     */
    private $cotes;

    /**
     * @ORM\OneToMany(targetEntity=Candidat::class, mappedBy="competition", orphanRemoval=true, cascade={"persist"},fetch="EAGER")
     */
    private $candidats;

    public function __construct()
    {
        $this->themes = new ArrayCollection();
        $this->cotes = new ArrayCollection();
        $this->candidats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
     public function setId($id): self
    {
        $this->id=$id;
        return $this;
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

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateCompetition(): ?\DateTimeInterface
    {
        return $this->date_competition;
    }

    public function setDateCompetition(\DateTimeInterface $date_competition): self
    {
        $this->date_competition = $date_competition;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    /**
     * @return Collection|Theme[]
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
            $theme->setCompetition($this);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        if ($this->themes->contains($theme)) {
            $this->themes->removeElement($theme);
            // set the owning side to null (unless already changed)
            if ($theme->getCompetition() === $this) {
                $theme->setCompetition(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cote[]
     */
    public function getCotes(): Collection
    {
        return $this->cotes;
    }

    public function addCote(Cote $cote): self
    {
        if (!$this->cotes->contains($cote)) {
            $this->cotes[] = $cote;
            $cote->setCompetition($this);
        }

        return $this;
    }

    public function removeCote(Cote $cote): self
    {
        if ($this->cotes->contains($cote)) {
            $this->cotes->removeElement($cote);
            // set the owning side to null (unless already changed)
            if ($cote->getCompetition() === $this) {
                $cote->setCompetition(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Candidat[]
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): self
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats[] = $candidat;
            $candidat->setCompetition($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): self
    {
        if ($this->candidats->contains($candidat)) {
            $this->candidats->removeElement($candidat);
            // set the owning side to null (unless already changed)
            if ($candidat->getCompetition() === $this) {
                $candidat->setCompetition(null);
            }
        }

        return $this;
    }
}
