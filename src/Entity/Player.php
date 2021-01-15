<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlayerRepository::class)
 */
class Player
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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $coordX;

    /**
     * @ORM\Column(type="integer")
     */
    private $coordY;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=Picture::class, mappedBy="player")
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=PlayerMission::class, mappedBy="player", cascade={"persist", "remove"})
     */
    private $playerMissions;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isInfected;


    public function __construct()
    {
        $this->playerMissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCoordX(): ?int
    {
        return $this->coordX;
    }

    public function setCoordX(int $coordX): self
    {
        $this->coordX = $coordX;

        return $this;
    }

    public function getCoordY(): ?int
    {
        return $this->coordY;
    }

    public function setCoordY(int $coordY): self
    {
        $this->coordY = $coordY;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    public function getPicture(): ?Picture
    {
        return $this->picture;
    }

    public function setPicture(?Picture $picture): self
    {
        // unset the owning side of the relation if necessary
        if ($picture === null && $this->picture !== null) {
            $this->picture->setPlayer(null);
        }

        // set the owning side of the relation if necessary
        if ($picture !== null && $picture->getPlayer() !== $this) {
            $picture->setPlayer($this);
        }

        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection|PlayerMission[]
     */
    public function getPlayerMissions(): Collection
    {
        return $this->playerMissions;
    }

    public function addPlayerMission(PlayerMission $playerMission): self
    {
        if (!$this->playerMissions->contains($playerMission)) {
            $this->playerMissions[] = $playerMission;
            $playerMission->setPlayer($this);
        }

        return $this;
    }

    public function removePlayerMission(PlayerMission $playerMission): self
    {
        if ($this->playerMissions->removeElement($playerMission)) {
            // set the owning side to null (unless already changed)
            if ($playerMission->getPlayer() === $this) {
                $playerMission->setPlayer(null);
            }
        }

        return $this;
    }

    public function getIsInfected(): ?bool
    {
        return $this->isInfected;
    }

    public function setIsInfected(?bool $isInfected): self
    {
        $this->isInfected = $isInfected;

        return $this;
    }
}
