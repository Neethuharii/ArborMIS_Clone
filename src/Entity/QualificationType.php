<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\QualificationTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QualificationTypeRepository::class)]
class QualificationType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: "qualification_id", type: "integer")]
    private ?int $qualification_id = null;

    #[ORM\Column(length: 255)]
    private ?string $qualification_name = null;
    /**
     * @var Collection<int, QualificationChecks>
     */
    #[ORM\OneToMany(targetEntity: QualificationChecks::class, mappedBy: 'qualificationType')]
    private Collection $qualificationChecks;

    public function __construct()
    {
        $this->qualificationChecks = new ArrayCollection();
    }

    /**
     * @return Collection<int, QualificationChecks>
     */
    public function getQualificationChecks(): Collection
    {
        return $this->qualificationChecks;
    }

    public function addQualificationCheck(QualificationChecks $qualificationCheck): static
    {
        if (!$this->qualificationChecks->contains($qualificationCheck)) {
            $this->qualificationChecks->add($qualificationCheck);
            $qualificationCheck->setQualificationType($this);
        }
        return $this;
    }

    public function removeQualificationCheck(QualificationChecks $qualificationCheck): static
    {
        if ($this->qualificationChecks->removeElement($qualificationCheck)) {
            if ($qualificationCheck->getQualificationType() === $this) {
                $qualificationCheck->setQualificationType(null);
            }
        }
        return $this;
    }

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
