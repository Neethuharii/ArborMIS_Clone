<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\HolidaysRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HolidaysRepository::class)]
class Holidays
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $holiday_id = null;

    #[ORM\Column(length: 100)]
    private ?string $holiday_name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $from_date = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $to_date = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getHolidayId(): ?int
    {
        return $this->holiday_id;
    }

    public function getHolidayName(): ?string
    {
        return $this->holiday_name;
    }

    public function setHolidayName(string $holiday_name): static
    {
        $this->holiday_name = $holiday_name;

        return $this;
    }

    public function getFromDate(): ?\DateTimeImmutable
    {
        return $this->from_date;
    }

    public function setFromDate(\DateTimeImmutable $from_date): static
    {
        $this->from_date = $from_date;

        return $this;
    }

    public function getToDate(): ?\DateTimeImmutable
    {
        return $this->to_date;
    }

    public function setToDate(\DateTimeImmutable $to_date): static
    {
        $this->to_date = $to_date;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
