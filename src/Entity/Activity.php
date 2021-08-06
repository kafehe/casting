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
    private $name_activity;
    /**
     * @ORM\Column(type="integer")
     */
    private $member;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="activities")
     * 
     */
    private $user;
    /**
     * @ORM\ManyToMany(targetEntity=Roleplay::class, mappedBy="actitvitiesTodo")
     */
    private $roleplays;

    public function __construct()
    {
        $this->roleplays = new ArrayCollection();
        $this->user = new ArrayCollection();
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

    public function getNameActivity(): ?string
    {
        return $this->name_activity;
    }

    public function setNameActivity(string $name_activity): self
    {
        $this->name_activity = $name_activity;

        return $this;
    }

    public function getMember(): ?int
    {
        return $this->member;
    }

    public function setMember(int $member): self
    {
        $this->member = $member;

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