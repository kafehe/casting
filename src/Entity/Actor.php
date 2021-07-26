<?php

namespace App\Entity;

use App\Repository\ActorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActorRepository::class)
 */
class Actor extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Agent::class, inversedBy="actors")
     */
    private $agent;

    /**
     * @ORM\ManyToMany(targetEntity=Activity::class, mappedBy="actors")
     */
    private $activities;

    /**
     * @ORM\OneToMany(targetEntity=Roleplay::class, mappedBy="actor")
     */
    private $roleplays;

    public function __construct()
    {
        parent::__construct();
        $this->activities = new ArrayCollection();
        $this->roleplays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivity(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
            $activity->addActor($this);
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        if ($this->activities->removeElement($activity)) {
            $activity->removeActor($this);
        }

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
            $roleplay->setActor($this);
        }

        return $this;
    }

    public function removeRoleplay(Roleplay $roleplay): self
    {
        if ($this->roleplays->removeElement($roleplay)) {
            // set the owning side to null (unless already changed)
            if ($roleplay->getActor() === $this) {
                $roleplay->setActor(null);
            }
        }

        return $this;
    }
}
