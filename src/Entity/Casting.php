<?php

namespace App\Entity;

use App\Repository\CastingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CastingRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"casting:read"}},
 *      collectionOperations={"get","post"},
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
    private $description_cast;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $object_cast;
    /**
     * @ORM\Column(type="date")
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $date_cast;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $type_cast;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $location;
    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"casting:read"},{"casting:write"})
     */
    private $casting_place;

    /**
     * @ORM\OneToMany(targetEntity=Roleplay::class, mappedBy="casting")
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

    public function __construct()
    {
        $this->roleplays = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->documentsTodo = new ArrayCollection();
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

    public function getDescriptionCast(): ?string
    {
        return $this->description_cast;
    }

    public function setDescriptionCast(string $description_cast): self
    {
        $this->description_cast = $description_cast;

        return $this;
    }

    public function getObjectCast(): ?string
    {
        return $this->object_cast;
    }

    public function setObjectCast(string $object_cast): self
    {
        $this->object_cast = $object_cast;

        return $this;
    }

    public function getDateCast(): ?\DateTimeInterface
    {
        return $this->date_cast;
    }

    public function setDateCast(\DateTimeInterface $date_cast): self
    {
        $this->date_cast = $date_cast;

        return $this;
    }

    public function getTypeCast(): ?string
    {
        return $this->type_cast;
    }

    public function setTypeCast(string $type_cast): self
    {
        $this->type_cast = $type_cast;

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
        return $this->casting_place;
    }

    public function setCastingPlace(string $casting_place): self
    {
        $this->casting_place = $casting_place;

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
}