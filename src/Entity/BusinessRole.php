<?php

namespace App\Entity;

use App\Repository\BusinessRoleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BusinessRoleRepository::class)]
class BusinessRole
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $role_id = null;

    #[ORM\Column(length: 255)]
    private ?string $role = null;

    #[ORM\Column]
    private ?float $salary = null;

    public function getRoleId(): ?int
    {
        return $this->role_id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

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
}
