<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
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

    #[ORM\Column]
    private ?float $durationReal = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $start_date_forecast = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $end_date_forecast = null;

    #[ORM\Column]
    private ?float $durationForecast = null;


    #[ORM\ManyToOne(inversedBy: 'task')]
    private ?TypeOfTask $typeOfTask = null;

    #[ORM\ManyToOne(inversedBy: 'task')]
    private ?StateOfTask $stateOfTask = null;

    #[ORM\ManyToOne(inversedBy: 'task')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Project $project = null;

    /**
     * @var Collection<int, Assignement>
     */
    #[ORM\OneToMany(targetEntity: Assignement::class, mappedBy: 'task')]
    private Collection $assignements;

    public function __construct()
    {
        $this->assigned = new ArrayCollection();
        $this->assignements = new ArrayCollection();
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

    public function getDurationReal(): ?float
    {
        return $this->durationReal;
    }

    public function setDurationReal(float $durationReal): static
    {
        $this->durationReal = $durationReal;

        return $this;
    }

    public function getStartDateForecast(): ?\DateTimeImmutable
    {
        return $this->start_date_forecast;
    }

    public function setStartDateForecast(\DateTimeImmutable $start_date_forecast): static
    {
        $this->start_date_forecast = $start_date_forecast;

        return $this;
    }

    public function getEndDateForecast(): ?\DateTimeImmutable
    {
        return $this->end_date_forecast;
    }

    public function setEndDateForecast(\DateTimeImmutable $end_date_forecast): static
    {
        $this->end_date_forecast = $end_date_forecast;

        return $this;
    }

    public function getDurationForecast(): ?float
    {
        return $this->durationForecast;
    }

    public function setDurationForecast(float $durationForecast): static
    {
        $this->durationForecast = $durationForecast;

        return $this;
    }


    public function getTypeOfTask(): ?TypeOfTask
    {
        return $this->typeOfTask;
    }

    public function setTypeOfTask(?TypeOfTask $typeOfTask): static
    {
        $this->typeOfTask = $typeOfTask;

        return $this;
    }

    public function getStateOfTask(): ?StateOfTask
    {
        return $this->stateOfTask;
    }

    public function setStateOfTask(?StateOfTask $stateOfTask): static
    {
        $this->stateOfTask = $stateOfTask;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): static
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection<int, Assignement>
     */
    public function getAssignements(): Collection
    {
        return $this->assignements;
    }

    public function addAssignement(Assignement $assignement): static
    {
        if (!$this->assignements->contains($assignement)) {
            $this->assignements->add($assignement);
            $assignement->setTask($this);
        }

        return $this;
    }

    public function removeAssignement(Assignement $assignement): static
    {
        if ($this->assignements->removeElement($assignement)) {
            // set the owning side to null (unless already changed)
            if ($assignement->getTask() === $this) {
                $assignement->setTask(null);
            }
        }

        return $this;
    }
}
