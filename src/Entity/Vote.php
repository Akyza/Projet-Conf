<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoteRepository")
 */
class Vote
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
    private $vote;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Users", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUsers;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Conference", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $idConf;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVote(): ?string
    {
        return $this->vote;
    }

    public function setVote(string $vote): self
    {
        $this->vote = $vote;

        return $this;
    }

    public function getIdUsers(): ?Users
    {
        return $this->idUsers;
    }

    public function setIdUsers(Users $idUsers): self
    {
        $this->idUsers = $idUsers;

        return $this;
    }

    public function getIdConf(): ?Conference
    {
        return $this->idConf;
    }

    public function setIdConf(Conference $idConf): self
    {
        $this->idConf = $idConf;

        return $this;
    }
}
