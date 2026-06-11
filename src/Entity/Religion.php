<?php

namespace App\Entity;

use App\Repository\ReligionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReligionRepository::class)]
class Religion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $religionName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReligionName(): ?string
    {
        return $this->religionName;
    }

    public function setReligionName(string $religionName): static
    {
        $this->religionName = $religionName;

        return $this;
    }
}
