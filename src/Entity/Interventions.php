<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\InterventionRepository;
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
}
