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
    private $name_skill;
    /**
     * @ORM\Column(type="string",)
     */
    private $rating;

    /**
     * @ORM\ManyToMany(targetEntity=Profile::class, mappedBy="skills")
     */
    private $profilesTodo;

    public function __construct()
    {
        $this->profilesTodo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameSkill(): ?string
    {
        return $this->name_skill;
    }

    public function setNameSkill(string $name_skill): self
    {
        $this->name_skill = $name_skill;

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
}