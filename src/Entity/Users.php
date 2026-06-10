<?php

namespace App\Entity;


use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $StaffEmail = null;

    #[ORM\Column(length: 150)]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStaffEmail(): ?string
    {
        return $this->StaffEmail;
    }

    public function setStaffEmail(string $StaffEmail): static
    {
        $this->StaffEmail = $StaffEmail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
}
