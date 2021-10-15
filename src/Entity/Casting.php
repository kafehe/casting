<?php

namespace App\Entity;

use App\Repository\CastingRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CastingRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"casting:read"},{"casting:write"}},
 *      collectionOperations={
 *          "get",
 *          "post"
 *      },
 *      itemOperations = {"get","put","delete","patch"}
 * )
 *
 */
class Casting
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"casting:read"})
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $title;
    /**
     * @ORM\Column(type="text")
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $descriptionCast;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $objectCast;
    /**
     * @ORM\Column(type="date")
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $dateStart;
    /**
     * @ORM\Column(type="date")
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $end;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $typeCast;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $location;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $castingPlace;
    /**
     * @ORM\Column(type="datetime")
     *@Groups({"casting:read"},{"casting:write"})
     */
    private $publishedAt;
    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $compensation;
    /**
     * @ORM\OneToMany(targetEntity=Roleplay::class, mappedBy="casting")
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $roleplays;

    /**
     * @ORM\ManyToMany(targetEntity=Document::class, inversedBy="castings")
     */
    private $documentsTodo;

    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="casting", cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\ManyToMany(targetEntity=Activity::class, inversedBy="castings")
     */
    private $activities;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="castings")
     */
    private $user;

    public function __construct()
    {

        $this->roleplays = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->documentsTodo = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->publishedAt = new DateTime();
    }

    /**
     * @return DateTime
     */
    public function getPublishedAt(): DateTime
    {
        return $this->publishedAt;
    }

    /**
     * @param DateTime $publishedAt
     */
    public function setPublishedAt(DateTime $publishedAt)
    {
        $this->publishedAt = new \DateTime() ;
    }

    public function __toString()
    {
        return $this->getTitle();
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
            $roleplay->setCasting($this);
        }

        return $this;
    }

    public function removeRoleplay(Roleplay $roleplay): self
    {
        if ($this->roleplays->removeElement($roleplay)) {
            // set the owning side to null (unless already changed)
            if ($roleplay->getCasting() === $this) {
                $roleplay->setCasting(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(File $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setCasting($this);
        }

        return $this;
    }

    public function removeImage(File $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getCasting() === $this) {
                $image->setCasting(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCompensation(): ?string
    {
        return $this->compensation;
    }

    public function setCompensation(string $compensation): self
    {
        $this->compensation = $compensation;

        return $this;
    }

    public function getDescriptionCast(): ?string
    {
        return $this->descriptionCast;
    }

    public function setDescriptionCast(string $description_cast): self
    {
        $this->descriptionCast = $description_cast;

        return $this;
    }

    public function getObjectCast(): ?string
    {
        return $this->objectCast;
    }

    public function setObjectCast(string $object_cast): self
    {
        $this->objectCast = $object_cast;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->dateStart = $date_start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $date_end): self
    {
        $this->end = $date_end;

        return $this;
    }

    public function getTypeCast(): ?string
    {
        return $this->typeCast;
    }

    public function setTypeCast(string $type_cast): self
    {
        $this->typeCast = $type_cast;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getCastingPlace(): ?string
    {
        return $this->castingPlace;
    }

    public function setCastingPlace(string $casting_place): self
    {
        $this->castingPlace = $casting_place;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocumentsTodo(): Collection
    {
        return $this->documentsTodo;
    }

    public function addDocumentsTodo(Document $documentsTodo): self
    {
        if (!$this->documentsTodo->contains($documentsTodo)) {
            $this->documentsTodo[] = $documentsTodo;
        }

        return $this;
    }

    public function removeDocumentsTodo(Document $documentsTodo): self
    {
        $this->documentsTodo->removeElement($documentsTodo);

        return $this;
    }

    /**
     * @return Collection|Activity[]
     */
    public function getActivities(): Collection
    {
        return $this->activities;
    }

    public function addActivities(Activity $activity): self
    {
        if (!$this->activities->contains($activity)) {
            $this->activities[] = $activity;
        }

        return $this;
    }

    public function removeActivities(Activity $activity): self
    {
        $this->activities->removeElement($activity);

        return $this;
    }
}
