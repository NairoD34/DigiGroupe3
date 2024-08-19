<?php

namespace App\Entity;

use App\Repository\JobRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column]
    private ?float $hourRate = null;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'job')]
    private Collection $jobByDefault;

    /**
     * @var Collection<int, Participate>
     */
    #[ORM\OneToMany(targetEntity: Participate::class, mappedBy: 'job')]
    private Collection $participates;

    public function __construct()
    {
        $this->jobByDefault = new ArrayCollection();
        $this->participates = new ArrayCollection();
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

    public function getHourRate(): ?float
    {
        return $this->hourRate;
    }

    public function setHourRate(float $hourRate): static
    {
        $this->hourRate = $hourRate;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getJobByDefault(): Collection
    {
        return $this->jobByDefault;
    }

    public function addJobByDefault(User $jobByDefault): static
    {
        if (!$this->jobByDefault->contains($jobByDefault)) {
            $this->jobByDefault->add($jobByDefault);
            $jobByDefault->setJob($this);
        }

        return $this;
    }

    public function removeJobByDefault(User $jobByDefault): static
    {
        if ($this->jobByDefault->removeElement($jobByDefault)) {
            // set the owning side to null (unless already changed)
            if ($jobByDefault->getJob() === $this) {
                $jobByDefault->setJob(null);
            }
        }

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
            $participate->setJob($this);
        }

        return $this;
    }

    public function removeParticipate(Participate $participate): static
    {
        if ($this->participates->removeElement($participate)) {
            // set the owning side to null (unless already changed)
            if ($participate->getJob() === $this) {
                $participate->setJob(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->label ;
    }
}
