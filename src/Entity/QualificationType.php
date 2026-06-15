<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QualificationTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QualificationTypeRepository::class)]
class QualificationType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $qualification_id = null;

    #[ORM\Column(length: 255)]
    private ?string $qualification_name = null;

    public function getQualificationId(): ?int
    {
        return $this->qualification_id;
    }

    public function getQualificationName(): ?string
    {
        return $this->qualification_name;
    }

    public function setQualificationName(string $qualification_name): static
    {
        $this->qualification_name = $qualification_name;

        return $this;
    }
}
