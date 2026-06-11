<?php

namespace App\Entity;

use App\Repository\EthnicityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EthnicityRepository::class)]
class Ethnicity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_ethnicity = null;

    #[ORM\Column(length: 255)]
    private ?string $ethnicity_name = null;

    public function getId(): ?int
    {
        return $this->id_ethnicity;
    }

    public function getEthnicityName(): ?string
    {
        return $this->ethnicity_name;
    }

    public function setEthnicityName(string $ethnicity_name): static
    {
        $this->ethnicity_name = $ethnicity_name;

        return $this;
    }
}
