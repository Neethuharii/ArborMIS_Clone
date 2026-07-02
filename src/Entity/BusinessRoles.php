<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BusinessRolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BusinessrolesRepository::class)]
#[ORM\Table(name: 'businessroles')]

class BusinessRoles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $role_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name_of_role = null;

    #[ORM\Column]
    private ?float $salary = null;

    /**
     * @var Collection<int, CurrentRoles>
     */
    #[ORM\OneToMany(targetEntity: CurrentRoles::class, mappedBy: 'businessRole')]
    private Collection $currentRoles;

    public function __construct()
    {
        $this->currentRoles = new ArrayCollection();
    }

    public function getRoleId(): ?int
    {
        return $this->role_id;
    }

    public function getNameOfRole(): ?string
    {
        return $this->name_of_role;
    }

    public function setNameOfRole(string $name_of_role): static
    {
        $this->name_of_role = $name_of_role;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    /**
     * @return Collection<int, CurrentRoles>
     */
    public function getCurrentRoles(): Collection
    {
        return $this->currentRoles;
    }

    public function addCurrentRole(CurrentRoles $currentRole): static
    {
        if (!$this->currentRoles->contains($currentRole)) {
            $this->currentRoles->add($currentRole);
            $currentRole->setBusinessRole($this);
        }

        return $this;
    }

    public function removeCurrentRole(CurrentRoles $currentRole): static
    {
        if ($this->currentRoles->removeElement($currentRole)) {
            if ($currentRole->getBusinessRole() === $this) {
                $currentRole->setBusinessRole(null);
            }
        }

        return $this;
    }
}
