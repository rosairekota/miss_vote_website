<?php

namespace App\Entity;

use App\Repository\CoteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CoteRepository::class)
 */
class Cote
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $coteVotant;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $coteJury;

    /**
     * @ORM\ManyToOne(targetEntity=Votant::class, inversedBy="cotes", cascade={"persist"})
     */
    private $votant;

    /**
     * @ORM\ManyToOne(targetEntity=Candidat::class, inversedBy="cotes", cascade={"persist"})
     */
    private $candidat;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0, nullable=true)
     */
    private $montantPaye;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $datevote;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoteVotant(): ?int
    {
        return $this->coteVotant;
    }

    public function setCoteVotant(?int $coteVotant): self
    {
        $this->coteVotant = $coteVotant;

        return $this;
    }

    public function getCoteJury(): ?int
    {
        return $this->coteJury;
    }

    public function setCoteJury(?int $coteJury): self
    {
        $this->coteJury = $coteJury;

        return $this;
    }

    public function getVotant(): ?Votant
    {
        return $this->votant;
    }

    public function setVotant(?Votant $votant): self
    {
        $this->votant = $votant;

        return $this;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): self
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getMontantPaye(): ?string
    {
        return $this->montantPaye;
    }

    public function setMontantPaye(?string $montantPaye): self
    {
        $this->montantPaye = $montantPaye;

        return $this;
    }

    public function getDatevote(): ?\DateTimeInterface
    {
        return $this->datevote;
    }

    public function setDatevote(?\DateTimeInterface $datevote): self
    {
        $this->datevote = $datevote;

        return $this;
    }
}
