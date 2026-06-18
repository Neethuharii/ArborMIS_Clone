<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\GendersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GendersRepository::class)]
class Genders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]

    private ?int $genderId = null;

    #[ORM\Column(length: 150)]
    private ?string $genderType = null;

    public function getGenderId(): ?int
    {
        return $this->genderId;
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
