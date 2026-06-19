<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SuspensionDetailsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuspensionDetailsRepository::class)]
class SuspensionDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'suspension_detail_id', type:'integer')]
    private ?int $suspensionDetailId = null;

    #[ORM\ManyToOne(inversedBy: 'suspensionDetails')]
    #[ORM\JoinColumn(name:'student_id',referencedColumnName:'student_id', nullable: false)]
    private ?Students $student = null;

    #[ORM\ManyToOne(inversedBy: 'suspensionDetails')]
    #[ORM\JoinColumn(name:'suspension_id', referencedColumnName:'suspension_id', nullable: false)]
    private ?SuspensionReasons $suspensionReason = null;

    #[ORM\Column]
    private ?\DateTime $suspendedFrom = null;

    #[ORM\Column]
    private ?\DateTime $suspendedUntil = null;

    #[ORM\Column]
    private ?\DateTime $decisionMadeTime = null;

    #[ORM\Column]
    private ?int $daysLost = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $suspensionNotes = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $documentPath = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column( nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    public function __construct(){
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getSuspensionDetailId(): ?int
    {
        return $this->suspensionDetailId;
    }

    public function getStudent(): ?Students
    {
        return $this->student;
    }

    public function setStudent(?Students $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getSuspensionReason(): ?SuspensionReasons
    {
        return $this->suspensionReason;
    }

    public function setSuspensionReason(?SuspensionReasons $suspensionReason): static
    {
        $this->suspensionReason = $suspensionReason;

        return $this;
    }

    public function getSuspendedFrom(): ?\DateTime
    {
        return $this->suspendedFrom;
    }

    public function setSuspendedFrom(\DateTime $suspendedFrom): static
    {
        $this->suspendedFrom = $suspendedFrom;

        return $this;
    }

    public function getSuspendedUntil(): ?\DateTime
    {
        return $this->suspendedUntil;
    }

    public function setSuspendedUntil(\DateTime $suspendedUntil): static
    {
        $this->suspendedUntil = $suspendedUntil;

        return $this;
    }

    public function getDecisionMadeTime(): ?\DateTime
    {
        return $this->decisionMadeTime;
    }

    public function setDecisionMadeTime(\DateTime $decisionMadeTime): static
    {
        $this->decisionMadeTime = $decisionMadeTime;

        return $this;
    }

    public function getDaysLost(): ?int
    {
        return $this->daysLost;
    }

    public function setDaysLost(int $daysLost): static
    {
        $this->daysLost = $daysLost;

        return $this;
    }

    public function getSuspensionNotes(): ?string
    {
        return $this->suspensionNotes;
    }

    public function setSuspensionNotes(?string $suspensionNotes): static
    {
        $this->suspensionNotes = $suspensionNotes;

        return $this;
    }

    public function getDocumentPath(): ?string
    {
        return $this->documentPath;
    }

    public function setDocumentPath(?string $documentPath): static
    {
        $this->documentPath = $documentPath;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
