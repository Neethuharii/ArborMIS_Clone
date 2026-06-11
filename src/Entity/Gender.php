<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\GenderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GenderRepository::class)]
class Gender
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $genderType = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenderType(): ?string
    {
        return $this->genderType;
    }

    public function setGenderType(string $genderType): static
    {
        $this->genderType = $genderType;

        return $this;
    }
}
