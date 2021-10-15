<?php

namespace App\Entity;

use App\Repository\RoleplayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=RoleplayRepository::class)
 * @ApiResource(
 *     collectionOperations={"get","post"},
 *     itemOperations={"get"}
 * )
 * @ApiFilter(SearchFilter::class, properties={"casting":"exact"})
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
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $titleRole;
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $poste;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $rangeAge;
    /**
     * @ORM\Column(type="text")
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $descriptionRole;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $genderRole;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $nationality;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $requirement;

    /**
     * @ORM\ManyToMany(targetEntity=Activity::class, inversedBy="roleplays")
     */
    private $actitvitiesTodo;

    /**
     * @ORM\ManyToOne(targetEntity=Casting::class, inversedBy="roleplays")
     */
    private $casting;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="roleplays")
     */
    private $skills;

    public function __construct()
    {
        $this->actitvitiesTodo = new ArrayCollection();
        $this->skills = new ArrayCollection();
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

    /**
     * @return Collection|Skill[]
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkills(Skill $skills): self
    {
        if (!$this->skills->contains($skills)) {
            $this->skills[] = $skills;
        }

        return $this;
    }

    public function removeSkills(Skill $skills): self
    {
        $this->skills->removeElement($skills);

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
        return $this->titleRole;
    }

    public function setTitleRole(string $title_role): self
    {
        $this->titleRole = $title_role;

        return $this;
    }

    public function getPoste(): ?string
    {
        return $this->poste;
    }

    public function setPoste(string $poste): self
    {
        $this->poste = $poste;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getRequirement(): ?string
    {
        return $this->requirement;
    }

    public function setRequirement(string $require): self
    {
        $this->requirement = $require;

        return $this;
    }

    public function getRangeAge(): ?string
    {
        return $this->rangeAge;
    }

    public function setRangeAge(string $range_age): self
    {
        $this->rangeAge = $range_age;

        return $this;
    }

    public function getDescriptionRole(): ?string
    {
        return $this->descriptionRole;
    }

    public function setDescriptionRole(string $description_role): self
    {
        $this->descriptionRole = $description_role;

        return $this;
    }

    public function getGenderRole(): ?string
    {
        return $this->genderRole;
    }

    public function setGenderRole(string $gender_role): self
    {
        $this->genderRole = $gender_role;

        return $this;
    }
}
