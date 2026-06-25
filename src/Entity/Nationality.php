<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\NationalityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NationalityRepository::class)]
class Nationality
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $nationality_id = null;

    #[ORM\Column(length: 100)]
    private ?string $nationality_status = null;

    public function getNationalityId(): ?int
    {
        return $this->nationality_id;
    }

    public function getNationalityStatus(): ?string
    {
        return $this->nationality_status;
    }

    public function setNationalityStatus(string $nationality_status): static
    {
        $this->nationality_status = $nationality_status;

        return $this;
    }
}
