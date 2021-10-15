<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ActivityRepository::class)
 * @ApiResource()
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
     * @ORM\Column(type="string",length=100)
     */
    private $nameActivity;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="activities")
     *
     */
    private $user;
    /**
     * @ORM\ManyToMany(targetEntity=Roleplay::class, mappedBy="actitvitiesTodo")
     */
    private $roleplays;

    /**
     * @ORM\ManyToMany(targetEntity=Casting::class, mappedBy="activities")
     */
    private $castings;

    public function __construct()
    {
        $this->roleplays = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->castings= new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNameActivity();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|Casting[]
     */
    public function getCastings(): Collection
    {
        return $this->castings;
    }

    public function addCastings(Casting $casting): self
    {
        if (!$this->castings->contains($casting)) {
            $this->castings[] = $casting;
            $casting->addActivities($this);
        }

        return $this;
    }

    public function removeCastings(Casting $casting): self
    {
        if ($this->castings->removeElement($casting)) {
            $casting->removeActivities($this);
        }

        return $this;
    }

    public function getNameActivity(): ?string
    {
        return $this->nameActivity;
    }

    public function setNameActivity(string $name_activity): self
    {
        $this->nameActivity = $name_activity;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->addActivity($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            $user->removeActivity($this);
        }

        return $this;
    }
}
