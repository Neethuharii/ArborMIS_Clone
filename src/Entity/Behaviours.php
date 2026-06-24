<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BehavioursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BehavioursRepository::class)]
class Behaviours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'behaviour_id', type:'integer')]
    private ?int $behaviourId = null;

    #[ORM\Column(length: 150)]
    private ?string $behaviourName = null;

    #[ORM\ManyToOne(inversedBy: 'behaviours')]
    #[ORM\JoinColumn(name:'category_id', referencedColumnName: 'category_id', nullable: false)]
    private ?Categories $category = null;

    /**
     * @var Collection<int, BehaviourIncidents>
     */
    #[ORM\OneToMany(targetEntity: BehaviourIncidents::class, mappedBy: 'behaviour')]
    private Collection $behaviourIncidents;

    public function __construct()
    {
        $this->behaviourIncidents = new ArrayCollection();
    }

    public function getbehaviourId(): ?int
    {
        return $this->behaviourId;
    }

    public function getBehaviourName(): ?string
    {
        return $this->behaviourName;
    }

    public function setBehaviourName(string $behaviourName): static
    {
        $this->behaviourName = $behaviourName;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, BehaviourIncidents>
     */
    public function getBehaviourIncidents(): Collection
    {
        return $this->behaviourIncidents;
    }

    public function addBehaviourIncident(BehaviourIncidents $behaviourIncident): static
    {
        if (!$this->behaviourIncidents->contains($behaviourIncident)) {
            $this->behaviourIncidents->add($behaviourIncident);
            $behaviourIncident->setBehaviour($this);
        }

        return $this;
    }

    public function removeBehaviourIncident(BehaviourIncidents $behaviourIncident): static
    {
        if ($this->behaviourIncidents->removeElement($behaviourIncident)) {
            // set the owning side to null (unless already changed)
            if ($behaviourIncident->getBehaviour() === $this) {
                $behaviourIncident->setBehaviour(null);
            }
        }

        return $this;
    }
}
