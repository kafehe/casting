<?php

namespace App\Entity;

use App\Repository\RoleplayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoleplayRepository::class)
 */
class Roleplay
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Activity::class, inversedBy="roleplays")
     */
    private $actitvitiesTodo;

    /**
     * @ORM\ManyToOne(targetEntity=Actor::class, inversedBy="roleplays")
     */
    private $actor;

    /**
     * @ORM\ManyToOne(targetEntity=Casting::class, inversedBy="roleplays")
     */
    private $casting;

    public function __construct()
    {
        $this->actitvitiesTodo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActitvitiesTodo(): Collection
    {
        return $this->actitvitiesTodo;
    }

    public function addActitvitiesTodo(Activity $actitvitiesTodo): self
    {
        if (!$this->actitvitiesTodo->contains($actitvitiesTodo)) {
            $this->actitvitiesTodo[] = $actitvitiesTodo;
        }

        return $this;
    }

    public function removeActitvitiesTodo(Activity $actitvitiesTodo): self
    {
        $this->actitvitiesTodo->removeElement($actitvitiesTodo);

        return $this;
    }

    public function getActor(): ?Actor
    {
        return $this->actor;
    }

    public function setActor(?Actor $actor): self
    {
        $this->actor = $actor;

        return $this;
    }

    public function getCasting(): ?Casting
    {
        return $this->casting;
    }

    public function setCasting(?Casting $casting): self
    {
        $this->casting = $casting;

        return $this;
    }
}
