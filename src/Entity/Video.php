<?php

namespace App\Entity;

use App\Repository\VideoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
//use ApiPlatform\Metadata\ApiResource;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=VideoRepository::class)
 * @ORM\Table(name="videos")
 * @ORM\HasLifecycleCallbacks
 */
class Video
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="Votre titre doit avoir un nom")
     * @Assert\Length(min=3, minMessage="Vous devez avoir un titre de minimum {{ limit }} caractères !")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $video;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Votre description doit contenir du texte")
     * @Assert\Length(min=20, minMessage="Vous devez avoir un titre de minimum {{ limit }} caractères !")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", options={"default":"CURRENT_TIMESTAMP"})
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="boolean")
     */
    private $premiumVideo;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTimeImmutable);
        }
        $this->setUpdatedAt(new \DateTimeImmutable);
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

    public function isPremiumVideo(): ?bool
    {
        return $this->premiumVideo;
    }

    public function setPremiumVideo(bool $premiumVideo): self
    {
        $this->premiumVideo = $premiumVideo;

        return $this;
    }

   

    
}
