<?php

namespace App\Entity;

use App\Repository\StateOfProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StateOfProjectRepository::class)]
class StateOfProject
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, Project>
     */
    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'stateOfProject')]
    private Collection $project;

    public function __construct()
    {
        $this->project = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Project>
     */
    public function getProject(): Collection
    {
        return $this->project;
    }

    public function addProject(Project $project): static
    {
        if (!$this->project->contains($project)) {
            $this->project->add($project);
            $project->setStateOfProject($this);
        }

        return $this;
    }

    public function removeProject(Project $project): static
    {
        if ($this->project->removeElement($project)) {
            // set the owning side to null (unless already changed)
            if ($project->getStateOfProject() === $this) {
                $project->setStateOfProject(null);
            }
        }

        return $this;
    }
}
