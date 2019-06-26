<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentaireRepository")
 */
class Commentaire
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
    private $commentaire;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Users", mappedBy="no")
     */
    private $idUser;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Conference", mappedBy="commentaire")
     */
    private $idConf;

    public function __construct()
    {
        $this->idUser = new ArrayCollection();
        $this->idConf = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getIdUser(): Collection
    {
        return $this->idUser;
    }

    public function addIdUser(Users $idUser): self
    {
        if (!$this->idUser->contains($idUser)) {
            $this->idUser[] = $idUser;
            $idUser->setNo($this);
        }

        return $this;
    }

    public function removeIdUser(Users $idUser): self
    {
        if ($this->idUser->contains($idUser)) {
            $this->idUser->removeElement($idUser);
            // set the owning side to null (unless already changed)
            if ($idUser->getNo() === $this) {
                $idUser->setNo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Conference[]
     */
    public function getIdConf(): Collection
    {
        return $this->idConf;
    }

    public function addIdConf(Conference $idConf): self
    {
        if (!$this->idConf->contains($idConf)) {
            $this->idConf[] = $idConf;
            $idConf->setCommentaire($this);
        }

        return $this;
    }

    public function removeIdConf(Conference $idConf): self
    {
        if ($this->idConf->contains($idConf)) {
            $this->idConf->removeElement($idConf);
            // set the owning side to null (unless already changed)
            if ($idConf->getCommentaire() === $this) {
                $idConf->setCommentaire(null);
            }
        }

        return $this;
    }
}
