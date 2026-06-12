<?php

namespace App\Entity;

use App\Repository\DocumentTypesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DocumentTypesRepository::class)]
class DocumentTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $documentTypeId = null;

    #[ORM\Column(length: 255)]
    private ?string $documentTypeName = null;

    public function getDocumentTypeId(): ?int
    {
        return $this->documentTypeId;
    }

    public function getDocumentTypeName(): ?string
    {
        return $this->documentTypeName;
    }

    public function setDocumentTypeName(string $documentTypeName): static
    {
        $this->documentTypeName = $documentTypeName;

        return $this;
    }
}
