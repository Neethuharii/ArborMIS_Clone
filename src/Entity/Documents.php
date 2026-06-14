<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\DocumentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentsRepository::class)]
class Documents
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $documentId = null;

    #[ORM\Column(length: 150)]
    private ?string $documentNumber = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'document_type_id', referencedColumnName: 'documentTypeId',nullable: false)]
    private ?DocumentTypes $documentType = null;

    #[ORM\Column]
    private ?\DateTimeInterface  $issueDate = null;

    #[ORM\Column]
    private ?\DateTimeInterface  $expiryDate = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    public function getDocumentId(): ?int
    {
        return $this->documentId;
    }

    public function getDocumentNumber(): ?string
    {
        return $this->documentNumber;
    }

    public function setDocumentNumber(string $documentNumber): static
    {
        $this->documentNumber = $documentNumber;

        return $this;
    }

    public function getDocumentType(): ?DocumentTypes
    {
        return $this->documentType;
    }

    public function setDocumentType(?DocumentTypes $documentType): static
    {
        $this->documentType = $documentType;

        return $this;
    }

    public function getIssueDate(): ?\DateTimeInterface 
    {
        return $this->issueDate;
    }

    public function setIssueDate(\DateTimeInterface  $issueDate): static
    {
        $this->issueDate = $issueDate;

        return $this;
    }

    public function getExpiryDate(): ?\DateTimeInterface 
    {
        return $this->expiryDate;
    }

    public function setExpiryDate(\DateTimeInterface  $expiryDate): static
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeImmutable $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }
}
