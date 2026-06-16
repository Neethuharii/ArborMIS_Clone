<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SuspensionReasonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuspensionReasonRepository::class)]
class SuspensionReasons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'suspension_id', type:'integer')]
    private ?int $suspensionId = null;

    #[ORM\Column(name:'suspension_reason', length: 50)]
    private ?string $suspensionReason = null;

    /**
     * @var Collection<int, SuspensionDetails>
     */
    #[ORM\OneToMany(targetEntity: SuspensionDetails::class, mappedBy: 'suspensionReason')]
    private Collection $suspensionDetails;

    public function __construct()
    {
        $this->suspensionDetails = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, SuspensionDetails>
     */
    public function getSuspensionDetails(): Collection
    {
        return $this->suspensionDetails;
    }

    public function addSuspensionDetail(SuspensionDetails $suspensionDetail): static
    {
        if (!$this->suspensionDetails->contains($suspensionDetail)) {
            $this->suspensionDetails->add($suspensionDetail);
            $suspensionDetail->setSuspensionReason($this);
        }

        return $this;
    }

    public function removeSuspensionDetail(SuspensionDetails $suspensionDetail): static
    {
        if ($this->suspensionDetails->removeElement($suspensionDetail)) {
            // set the owning side to null (unless already changed)
            if ($suspensionDetail->getSuspensionReason() === $this) {
                $suspensionDetail->setSuspensionReason(null);
            }
        }

        return $this;
    }
}
