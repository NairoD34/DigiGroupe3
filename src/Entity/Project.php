<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $start_date = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $end_date = null;

    /**
     * @var Collection<int, Task>
     */
    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'project')]
    private Collection $task;

    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $manages = null;

    #[ORM\ManyToOne(inversedBy: 'project')]
    #[ORM\JoinColumn(nullable: false)]
    private ?StateOfProject $stateOfProject = null;

    #[ORM\ManyToOne(inversedBy: 'project')]
    private ?Client $client = null;

    /**
     * @var Collection<int, Participate>
     */
    #[ORM\OneToMany(targetEntity: Participate::class, mappedBy: 'project')]
    private Collection $participates;

    public function __construct()
    {
        $this->task = new ArrayCollection();
        $this->participates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeImmutable $start_date): static
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeImmutable $end_date): static
    {
        $this->end_date = $end_date;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTask(): Collection
    {
        return $this->task;
    }

    public function addTask(Task $task): static
    {
        if (!$this->task->contains($task)) {
            $this->task->add($task);
            $task->setProject($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->task->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProject() === $this) {
                $task->setProject(null);
            }
        }

        return $this;
    }

    public function getManages(): ?User
    {
        return $this->manages;
    }

    public function setManages(?User $manages): static
    {
        $this->manages = $manages;

        return $this;
    }

    public function getStateOfProject(): ?StateOfProject
    {
        return $this->stateOfProject;
    }

    public function setStateOfProject(?StateOfProject $stateOfProject): static
    {
        $this->stateOfProject = $stateOfProject;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Participate>
     */
    public function getParticipates(): Collection
    {
        return $this->participates;
    }

    public function addParticipate(Participate $participate): static
    {
        if (!$this->participates->contains($participate)) {
            $this->participates->add($participate);
            $participate->setProject($this);
        }

        return $this;
    }

    public function removeParticipate(Participate $participate): static
    {
        if ($this->participates->removeElement($participate)) {
            // set the owning side to null (unless already changed)
            if ($participate->getProject() === $this) {
                $participate->setProject(null);
            }
        }

        return $this;
    }
}
