<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SuspensionReasonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuspensionReasonRepository::class)]
class SuspensionReason
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'suspension_id', type:'integer')]
    private ?int $suspensionId = null;

    #[ORM\Column(name:'suspension_reason', length: 50)]
    private ?string $suspensionReason = null;

    public function getSuspensionId(): ?int
    {
        return $this->suspensionId;
    }

    public function getSuspensionReason(): ?string
    {
        return $this->suspensionReason;
    }

    public function setSuspensionReason(string $suspensionReason): static
    {
        $this->suspensionReason = $suspensionReason;

        return $this;
    }
}
