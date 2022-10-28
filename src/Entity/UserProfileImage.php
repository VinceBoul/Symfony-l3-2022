<?php

namespace App\Entity;

use App\Repository\UserProfileImageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: UserProfileImageRepository::class)]
class UserProfileImage
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[Vich\UploadableField(mapping: 'user_profiles', fileNameProperty: 'imageName', size: 'imageSize')]
  private ?File $imageFile = null;

  #[ORM\Column(length: 255)]
  private ?string $imageName = null;

  #[ORM\Column]
  private ?int $imageSize = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE)]
  private ?\DateTimeInterface $updatedAt = null;

  public function getId(): ?int
  {
    return $this->id;
  }

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


  public function getImageName(): ?string
  {
    return $this->imageName;
  }

  public function setImageName(string $imageName): self
  {
    $this->imageName = $imageName;

    return $this;
  }

  public function getImageSize(): ?int
  {
    return $this->imageSize;
  }

  public function setImageSize(int $imageSize): self
  {
    $this->imageSize = $imageSize;

    return $this;
  }

  public function getUpdatedAt(): ?\DateTimeInterface
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt(\DateTimeInterface $updatedAt): self
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }
}
