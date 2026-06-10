<?php

namespace App\Entity;

use App\Repository\InterventionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InterventionRepository::class)]
class Intervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'physical_id')]
    private ?int $physicalId = null;

    

    #[ORM\Column(length: 255)]
    private ?string $interventionMethod = null;

    public function getPhysicalId(): ?int
    {
        return $this->physicalId;
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
}
