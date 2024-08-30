<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Project
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Name is required")]
    #[ORM\Column(type: 'string', length: 200)]
    private string $name;

    #[Assert\NotBlank(message: "Location is required")]
    #[ORM\Column(type: 'string', length: 500)]
    private string $location;

    #[Assert\NotBlank(message: "Stage is required")]
    #[ORM\Column(type: 'string', length: 50)]
    private string $stage;

    #[Assert\NotBlank(message: "Category is required")]
    #[ORM\Column(type: 'string', length: 50)]
    private string $category;

    #[ORM\Column(type: 'date')]
    private \DateTime $constructionStartDate;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[Assert\NotBlank(message: "Creator ID is required")]
    #[Assert\Length(
        min: 6,
        max: 6,
        exactMessage: "Creator ID must be exactly 6 characters"
    )]
    #[ORM\Column(type: 'string', length: 6)]
    private string $creatorId;

    public function __construct()
    {
        // Initialization logic if needed
    }

    // Getters and Setters...

    #[ORM\PrePersist]
    public function generateId(): void
    {
        if ($this->id === null) {
            $this->id = $this->generateUniqueId();
        }
    }

    private function generateUniqueId(): int
    {
        do {
            $id = random_int(100000, 999999); // Generate a 6-digit number
        } while ($this->idExists($id));

        return $id;
    }

    private function idExists(int $id): bool
    {
        // This should ideally be in a service or repository for better design
        return (bool) $entityManager->getRepository(Project::class)->find($id);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getStage(): string
    {
        return $this->stage;
    }

    public function setStage(string $stage): self
    {
        $this->stage = $stage;
        return $this;
    }

    public function getCategory(): string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getConstructionStartDate(): \DateTime
    {
        return $this->constructionStartDate;
    }

    public function setConstructionStartDate(\DateTime $constructionStartDate): self
    {
        $this->constructionStartDate = $constructionStartDate;
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

    public function getCreatorId(): string
    {
        return $this->creatorId;
    }

    public function setCreatorId(string $creatorId): self
    {
        $this->creatorId = $creatorId;
        return $this;
    }
}