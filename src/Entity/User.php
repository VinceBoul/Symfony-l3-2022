<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Serializable
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

  #[ORM\OneToMany(mappedBy: 'user', targetEntity: Product::class)]
  private Collection $articles;

  #[ORM\OneToMany(mappedBy: 'author', targetEntity: Article::class)]
  private Collection $publications;

  #[ORM\OneToOne(cascade: ['persist', 'remove'])]
  private ?UserProfileImage $userProfileImage = null;

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

  public function getUserProfileImage(): ?UserProfileImage
  {
      return $this->userProfileImage;
  }

  public function setUserProfileImage(?UserProfileImage $userProfileImage): self
  {
      $this->userProfileImage = $userProfileImage;

      return $this;
  }

  public function serialize()
  {
    return serialize([
      'id' => $this->getId(),
      'password' => $this->getPassword()]);
  }

  public function unserialize($serialized)
  {
    $data = unserialize($serialized);
    $this->id = $data['id'];
    $this->password = $data['password'];
  }
}
