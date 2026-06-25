<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Interventions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'intervention_id', type: 'integer')]
    private ?int $interventionId = null;
    
    #[ORM\Column(length: 255)]
    private ?string $interventionMethod = null;

    /**
     * @var Collection<int, InterventionDetail>
     */
    #[ORM\OneToMany(targetEntity: InterventionDetail::class, mappedBy: 'interventionId')]
    private Collection $interventionDetails;

    public function __construct()
    {
        $this->interventionDetails = new ArrayCollection();
    }

    public function getInterventionId(): ?int
    {
        return $this->interventionId;
    }

    public function getInterventionMethod(): ?string
    {
        return $this->interventionMethod;
    }

    public function setInterventionMethod(string $interventionMethod): static
    {
        $this->interventionMethod = $interventionMethod;

        return $this;
    }

    /**
     * @return Collection<int, InterventionDetail>
     */
    public function getInterventionDetails(): Collection
    {
        return $this->interventionDetails;
    }

    public function addInterventionDetail(InterventionDetail $interventionDetail): static
    {
        if (!$this->interventionDetails->contains($interventionDetail)) {
            $this->interventionDetails->add($interventionDetail);
            $interventionDetail->setIntervention($this);
        }

        return $this;
    }

    public function removeInterventionDetail(InterventionDetail $interventionDetail): static
    {
        if ($this->interventionDetails->removeElement($interventionDetail)) {
            // set the owning side to null (unless already changed)
            if ($interventionDetail->getIntervention() === $this) {
                $interventionDetail->setIntervention(null);
            }
        }

        return $this;
    }
}

