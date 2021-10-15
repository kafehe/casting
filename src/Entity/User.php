<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * * @ApiResource(
 *     collectionOperations={},
 *     itemOperations={
 *          "get"={
 *             "controller"=NotFoundAction::class,
 *             "openapi_context"={"summary"="hidden"},
 *             "read"=false,
 *             "output"=false,
 *         },
 *          "me" = {
 *              "pagination_enabled"=false,
 *              "path"= "/me",
 *              "method"= "get",
 *              "controller"= App\Controller\MeController::class,
 *              "read"=false,
 *              "openapi_context" = {
 *                  "security" = {{"bearerAuth"={}}}
 *              }
 *         }
 *     },
 *     normalizationContext={"groups"={"user:read"}}
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"user:read"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     * @ORM\Column(type="date", length=100)
     */
    private $birthDate;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastname;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $phone;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nationality;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $company;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $gender;

    /**
     * @ORM\OneToOne(targetEntity=File::class, cascade={"persist", "remove"})
     */
    private $profileImage;
    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="user")
     */
    private $document;
    /**
     * @ORM\OneToOne(targetEntity=Profile::class,cascade={"persist", "remove"},  inversedBy="user")
     */
    private $profile;
    /**
     * @ORM\OneToMany(targetEntity=File::class, mappedBy="user")
     */
    private $images;
    /**
     * @ORM\ManyToMany(targetEntity=Activity::class, inversedBy="user")
     */
    private $activities;
    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="manager")
     */
    private $user;
    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="user")
     */
    private $manager;
    /**
     * @ORM\OneToMany(targetEntity=Casting::class, mappedBy="user")
     */
    private $castings;

    /**
     * @ORM\ManyToMany(targetEntity=Skill::class, inversedBy="user")
     */
    private $skillsTodo;

    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->castings = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->document = new ArrayCollection();
        $this->activities = new ArrayCollection();
        $this->skillsTodo = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getFirstname();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|Roleplay[]
     */
    public function getCasting(): Collection
    {
        return $this->castings;
    }

    public function addCastings(Casting $casting): self
    {
        if (!$this->castings->contains($casting)) {
            $this->castings[] = $casting;
            $casting->setUser($this);
        }

        return $this;
    }

    public function removeCastings(Casting $casting): self
    {
        if ($this->castings->removeElement($casting)) {
            // set the owning side to null (unless already changed)
            if ($casting->getUser() === $this) {
                $casting->setUser(null);
            }
        }

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see  UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles ;
        // guarantee every user at least has ROLE_USER

        return array($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }


    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getProfileImage(): ?File
    {
        return $this->profileImage;
    }

    public function setProfileImage(?File $profileImage): self
    {
        $this->profileImage = $profileImage;

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
            $image->setUser($this);
        }

        return $this;
    }

    public function removeImage(File $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getUser() === $this) {
                $image->setUser(null);
            }
        }

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birth_date): self
    {
        $this->birthDate = $birth_date;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

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

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocument(): Collection
    {
        return $this->document;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->document->contains($document)) {
            $this->document[] = $document;
            $document->setUser($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->document->removeElement($document)) {
            // set the owning side to null (unless already changed)
            if ($document->getUser() === $this) {
                $document->setUser(null);
            }
        }

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

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
            $user->setManager($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getManager() === $this) {
                $user->setManager(null);
            }
        }

        return $this;
    }

    public function getManager(): ?self
    {
        return $this->manager;
    }

    public function setManager(?self $manager): self
    {
        $this->manager = $manager;

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
        }

        return $this;
    }

    public function removeActivity(Activity $activity): self
    {
        $this->activities->removeElement($activity);

        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkillsTodo(): Collection
    {
        return $this->skillsTodo;
    }

    public function addSkillsTodo(Skill $skill): self
    {
        if (!$this->skillsTodo->contains($skill)) {
            $this->skillsTodo[] = $skill;
        }

        return $this;
    }

    public function removeSkillsTodo(Skill $skill): self
    {
        $this->skillsTodo->removeElement($skill);

        return $this;
    }
}
