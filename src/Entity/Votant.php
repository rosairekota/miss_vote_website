<?php

namespace App\Entity;

use App\Repository\VotantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VotantRepository::class)
 */
class Votant
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
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\OneToMany(targetEntity=Cote::class, mappedBy="votant", cascade={"persist"})
     */
    private $cotes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motdepass;

      /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $category;

       /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sexe;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="votant")
     */
    private $comments;

    public function __construct()
    {
        $this->cotes = new ArrayCollection();
        $this->comments = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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
            $cote->setVotant($this);
        }

        return $this;
    }

    public function removeCote(Cote $cote): self
    {
        if ($this->cotes->contains($cote)) {
            $this->cotes->removeElement($cote);
            // set the owning side to null (unless already changed)
            if ($cote->getVotant() === $this) {
                $cote->setVotant(null);
            }
        }

        return $this;
    }

    public function getMotdepass(): ?string
    {
        return $this->motdepass;
    }

    public function setMotdepass(string $motdepass): self
    {
        $this->motdepass = $motdepass;

        return $this;
    }
    

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setVotant($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getVotant() === $this) {
                $comment->setVotant(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of photoName
     */ 
    public function getPhotoName()
    {
        return $this->photoName;
    }

    /**
     * Set the value of photoName
     *
     * @return  self
     */ 
    public function setPhotoName($photoName)
    {
        $this->photoName = $photoName;

        return $this;
    }


    /**
     * Get the value of category
     */ 
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of sexe
     */ 
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set the value of sexe
     *
     * @return  self
     */ 
    public function setSexe($sexe):self
    {
        $this->sexe = $sexe;

        return $this;
    }
}
