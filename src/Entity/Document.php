<?php

namespace App\Entity;

use App\Repository\DocumentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 * @ApiResource()
 */
class Document
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
    private $nameDoc;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $typeDoc;
    /**
     * @ORM\Column(type="string")
     */
    private $path;
    /**
     * @ORM\ManyToMany(targetEntity=Casting::class, mappedBy="documentsTodo")
     */
    private $castings;
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="document")
     */
    private $user;
    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="document")
     */
    private $files;

    public function __construct()
    {
        $this->castings = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNameDoc();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameDoc(): ?string
    {
        return $this->nameDoc;
    }

    public function setNameDoc(string $name_doc): self
    {
        $this->nameDoc = $name_doc;

        return $this;
    }

    public function getTypeDoc(): ?string
    {
        return $this->typeDoc;
    }

    public function setTypeDoc(string $type_doc): self
    {
        $this->typeDoc = $type_doc;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Collection|Casting[]
     */
    public function getCastings(): Collection
    {
        return $this->castings;
    }

    public function addCasting(Casting $casting): self
    {
        if (!$this->castings->contains($casting)) {
            $this->castings[] = $casting;
            $casting->addDocumentsTodo($this);
        }

        return $this;
    }

    public function removeCasting(Casting $casting): self
    {
        if ($this->castings->removeElement($casting)) {
            $casting->removeDocumentsTodo($this);
        }

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

    /**
     * @return Collection|File[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->setDocument($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getDocument() === $this) {
                $file->setDocument(null);
            }
        }

        return $this;
    }
}
