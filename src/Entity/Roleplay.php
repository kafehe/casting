<?php

namespace App\Entity;

use App\Repository\RoleplayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RoleplayRepository::class)
 * @ApiResource()
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
     * @ORM\Column(type="string", length=100)
     */
    private $title_role;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstname_role;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastname_role;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $range_age;
    /**
     * @ORM\Column(type="text")
     */
    private $description_role;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $gender_role;

    /**
     * @ORM\ManyToMany(targetEntity=Activity::class, inversedBy="roleplays")
     */
    private $actitvitiesTodo;



    /**
     * @ORM\ManyToOne(targetEntity=Casting::class, inversedBy="roleplays")
     */
    private $casting;

    public function __construct()
    {
        $this->actitvitiesTodo = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitleRole();
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



    public function getCasting(): ?Casting
    {
        return $this->casting;
    }

    public function setCasting(?Casting $casting): self
    {
        $this->casting = $casting;

        return $this;
    }

    public function getTitleRole(): ?string
    {
        return $this->title_role;
    }

    public function setTitleRole(string $title_role): self
    {
        $this->title_role = $title_role;

        return $this;
    }

    public function getFirstnameRole(): ?string
    {
        return $this->firstname_role;
    }

    public function setFirstnameRole(string $firstname_role): self
    {
        $this->firstname_role = $firstname_role;

        return $this;
    }

    public function getLastnameRole(): ?string
    {
        return $this->lastname_role;
    }

    public function setLastnameRole(string $lastname_role): self
    {
        $this->lastname_role = $lastname_role;

        return $this;
    }

    public function getRangeAge(): ?string
    {
        return $this->range_age;
    }

    public function setRangeAge(string $range_age): self
    {
        $this->range_age = $range_age;

        return $this;
    }

    public function getDescriptionRole(): ?string
    {
        return $this->description_role;
    }

    public function setDescriptionRole(string $description_role): self
    {
        $this->description_role = $description_role;

        return $this;
    }

    public function getGenderRole(): ?string
    {
        return $this->gender_role;
    }

    public function setGenderRole(string $gender_role): self
    {
        $this->gender_role = $gender_role;

        return $this;
    }
}