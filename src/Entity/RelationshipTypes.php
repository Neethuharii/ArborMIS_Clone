<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\RelationshipTypesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelationshipTypesRepository::class)]
 class RelationshipTypes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "relationship_type_id")]
    private ?int $relationshipTypeId = null;

    #[ORM\Column(length: 150)]
    private ?string $relationshipTypeName = null;

    public function getRelationshipTypeId(): ?int
    {
        return $this->relationshipTypeId;
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
