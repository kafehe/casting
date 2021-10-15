<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillRepository::class)
 */
class Skill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nameSkill;
    /**
     * @ORM\Column(type="string",)
     */
    private $rating;
    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="skillsTodo")
     */
    private $user;
    /**
     * @ORM\ManyToMany(targetEntity=Profile::class, mappedBy="skills")
     */
    private $profilesTodo;

    /**
     * @ORM\ManyToMany(targetEntity=Roleplay::class, mappedBy="skills")
     */
    private $roleplays;

    public function __construct()
    {
        $this->profilesTodo = new ArrayCollection();
        $this->user = new ArrayCollection();
        $this->roleplays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameSkill(): ?string
    {
        return $this->nameSkill;
    }

    public function setNameSkill(string $name_skill): self
    {
        $this->nameSkill = $name_skill;

        return $this;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(string $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection|Profile[]
     */
    public function getProfilesTodo(): Collection
    {
        return $this->profilesTodo;
    }

    public function addProfilesTodo(Profile $profilesTodo): self
    {
        if (!$this->profilesTodo->contains($profilesTodo)) {
            $this->profilesTodo[] = $profilesTodo;
            $profilesTodo->addSkill($this);
        }

        return $this;
    }

    public function removeProfilesTodo(Profile $profilesTodo): self
    {
        if ($this->profilesTodo->removeElement($profilesTodo)) {
            $profilesTodo->removeSkill($this);
        }

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
            $user->addSkillsTodo($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            $user->removeSkillsTodo($this);
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

    public function addRoleplays(Roleplay $roleplay): self
    {
        if (!$this->roleplays->contains($roleplay)) {
            $this->roleplays[] = $roleplay;
            $roleplay->addSkills($this);
        }

        return $this;
    }

    public function removeRoleplays(Roleplay $roleplay): self
    {
        if ($this->roleplays->removeElement($roleplay)) {
            $roleplay->removeSkills($this);
        }

        return $this;
    }
}
