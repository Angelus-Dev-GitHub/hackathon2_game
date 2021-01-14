<?php

namespace App\Entity;

use App\Repository\MissionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MissionRepository::class)
 */
class Mission
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
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
     * @ORM\OneToMany(targetEntity=PlayerMission::class, mappedBy="mission")
     */
    private $playerMissions;

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
            $playerMission->setMission($this);
        }

        return $this;
    }

    public function removePlayerMission(PlayerMission $playerMission): self
    {
        if ($this->playerMissions->removeElement($playerMission)) {
            // set the owning side to null (unless already changed)
            if ($playerMission->getMission() === $this) {
                $playerMission->setMission(null);
            }
        }

        return $this;
    }
}
