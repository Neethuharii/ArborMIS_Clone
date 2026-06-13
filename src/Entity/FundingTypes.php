<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\FundingTypesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FundingTypesRepository::class)]
final class FundingTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $fundingTypeId = null;

    #[ORM\Column(length: 255)]
    private ?string $fundingTypeName = null;

    public function getFundingTypeId(): ?int
    {
        return $this->fundingTypeId;
    }

    public function getFundingTypeName(): ?string
    {
        return $this->fundingTypeName;
    }

    public function setFundingTypeName(string $fundingTypeName): static
    {
        $this->fundingTypeName = $fundingTypeName;

        return $this;
    }
}
