<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RelationshipTypesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelationshipTypesRepository::class)]
final class RelationshipTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $relationshipTypeid = null;

    #[ORM\Column(length: 150)]
    private ?string $relationshipTypeName = null;

    public function getRelationshipTypeId(): ?int
    {
        return $this->relationshipTypeid;
    }

    public function getRelationshipTypeName(): ?string
    {
        return $this->relationshipTypeName;
    }

    public function setRelationshipTypeName(string $relationshipTypeName): static
    {
        $this->relationshipTypeName = $relationshipTypeName;

        return $this;
    }
}
