<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 180, unique: true)]
  private ?string $email = null;

  #[ORM\Column]
  private array $roles = [];

  /**
   * @var string The hashed password
   */
  #[ORM\Column]
  private ?string $password = null;

  // NOTE: This is not a mapped field of entity metadata, just a simple property.
  #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName', size: 'imageSize')]
  private ?File $imageFile = null;

  #[ORM\Column(type: 'string')]
  private ?string $imageName = null;

  #[ORM\Column(type: 'integer')]
  private ?int $imageSize = null;

  #[ORM\Column(type: 'datetime')]
  private ?\DateTimeInterface $updatedAt = null;


  #[ORM\OneToMany(mappedBy: 'user', targetEntity: Product::class)]
  private Collection $articles;

  #[ORM\OneToMany(mappedBy: 'author', targetEntity: Article::class)]
  private Collection $publications;

  public function __construct()
  {
    $this->articles = new ArrayCollection();
    $this->publications = new ArrayCollection();
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
   * A visual identifier that represents this user.
   *
   * @see UserInterface
   */
  public function getUserIdentifier(): string
  {
    return (string) $this->email;
  }

  /**
   * @see UserInterface
   */
  public function getRoles(): array
  {
    $roles = $this->roles;
    // guarantee every user at least has ROLE_USER
    $roles[] = 'ROLE_USER';

    return array_unique($roles);
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
   * @see UserInterface
   */
  public function eraseCredentials()
  {
    // If you store any temporary, sensitive data on the user, clear it here
    // $this->plainPassword = null;
  }

  /**
   * @return Collection<int, Product>
   */
  public function getArticles(): Collection
  {
    return $this->articles;
  }

  public function addArticle(Product $article): self
  {
    if (!$this->articles->contains($article)) {
      $this->articles->add($article);
      $article->setUser($this);
    }

    return $this;
  }

  public function removeArticle(Product $article): self
  {
    if ($this->articles->removeElement($article)) {
      // set the owning side to null (unless already changed)
      if ($article->getUser() === $this) {
        $article->setUser(null);
      }
    }

    return $this;
  }

  /**
   * @return Collection<int, Article>
   */
  public function getPublications(): Collection
  {
    return $this->publications;
  }

  public function addPublication(Article $publication): self
  {
    if (!$this->publications->contains($publication)) {
      $this->publications->add($publication);
      $publication->setAuthor($this);
    }

    return $this;
  }

  public function removePublication(Article $publication): self
  {
    if ($this->publications->removeElement($publication)) {
      // set the owning side to null (unless already changed)
      if ($publication->getAuthor() === $this) {
        $publication->setAuthor(null);
      }
    }

    return $this;
  }

  public function __toString()
  {
    return 'Auteur : '.$this->getEmail();
  }

  /**
   * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
   * of 'UploadedFile' is injected into this setter to trigger the update. If this
   * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
   * must be able to accept an instance of 'File' as the bundle will inject one here
   * during Doctrine hydration.
   *
   * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
   */
  public function setImageFile(?File $imageFile = null): void
  {
    $this->imageFile = $imageFile;

    if (null !== $imageFile) {
      // It is required that at least one field changes if you are using doctrine
      // otherwise the event listeners won't be called and the file is lost
      $this->updatedAt = new \DateTimeImmutable();
    }
  }

  public function getImageFile(): ?File
  {
    return $this->imageFile;
  }

  public function setImageName(?string $imageName): void
  {
    $this->imageName = $imageName;
  }

  public function getImageName(): ?string
  {
    return $this->imageName;
  }

  public function setImageSize(?int $imageSize): void
  {
    $this->imageSize = $imageSize;
  }

  public function getImageSize(): ?int
  {
    return $this->imageSize;
  }
}
