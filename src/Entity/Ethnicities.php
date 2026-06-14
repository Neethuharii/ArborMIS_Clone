<?php

namespace App\Entity;

use App\Repository\EthnicitiesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EthnicitiesRepository::class)]
class Ethnicities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $ethnicity_id = null;

    #[ORM\Column(length: 255)]
    private ?string $ethnicity_name = null;

    public function getEthnicityId(): ?int
    {
        return $this->ethnicity_id;
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
