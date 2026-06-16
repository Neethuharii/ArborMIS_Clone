<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\BusinessrolesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BusinessrolesRepository::class)]
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
}
