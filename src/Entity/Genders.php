<?php

namespace App\Entity;

use App\Repository\GendersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GendersRepository::class)]
class Genders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_gender = null;

    #[ORM\Column(length: 100)]
    private ?string $Gender = null;

    public function getId(): ?int
    {
        return $this->id_gender;
    }

    public function getGender(): ?string
    {
        return $this->Gender;
    }

    public function setGender(string $Gender): static
    {
        $this->Gender = $Gender;

        return $this;
    }
}
