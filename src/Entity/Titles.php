<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TitlesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TitlesRepository::class)]

class Titles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $title_id = null;

    #[ORM\Column(length: 255)]
    private ?string $title_name = null;

    public function getTitleId(): ?int
    {
        return $this->title_id;
    }

    public function getTitleName(): ?string
    {
        return $this->title_name;
    }

    public function setTitleName(string $title_name): static
    {
        $this->title_name = $title_name;

        return $this;
    }
}
