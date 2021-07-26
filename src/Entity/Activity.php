<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 */
class Activity
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=Actor::class, inversedBy="activities")
     */
    private $actors;

    /**
     * @ORM\ManyToMany(targetEntity=Roleplay::class, mappedBy="actitvitiesTodo")
     */
    private $roleplays;

    public function __construct()
    {
        $this->actors = new ArrayCollection();
        $this->roleplays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Actor[]
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors[] = $actor;
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        $this->actors->removeElement($actor);

        return $this;
    }

    /**
     * @return Collection|Roleplay[]
     */
    public function getRoleplays(): Collection
    {
        return $this->roleplays;
    }

    public function addRoleplay(Roleplay $roleplay): self
    {
        if (!$this->roleplays->contains($roleplay)) {
            $this->roleplays[] = $roleplay;
            $roleplay->addActitvitiesTodo($this);
        }

        return $this;
    }

    public function removeRoleplay(Roleplay $roleplay): self
    {
        if ($this->roleplays->removeElement($roleplay)) {
            $roleplay->removeActitvitiesTodo($this);
        }

        return $this;
    }
}
