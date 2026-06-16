<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BehavioursRepository;
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

    public function getId(): ?int
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
}
