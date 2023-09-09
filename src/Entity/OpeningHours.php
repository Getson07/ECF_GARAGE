<?php

namespace App\Entity;

use App\Repository\OpeningHoursRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OpeningHoursRepository::class)]
class OpeningHours
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique:true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id = null;

    #[ORM\Column(length: 20)]
    private ?string $day_of_week = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $opening_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closing_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $start_break_time = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $end_of_break = null;

    #[ORM\ManyToOne(inversedBy: 'schedules')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $scheduler = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getDayOfWeek(): ?string
    {
        return $this->day_of_week;
    }

    public function setDay(string $day): static
    {
        $this->day_of_week = $day;

        return $this;
    }

    public function getOpeningTime(): ?\DateTimeInterface
    {
        return $this->opening_time;
    }

    public function setOpeningTime(\DateTimeInterface $opening_time): static
    {
        $this->opening_time = $opening_time;

        return $this;
    }

    public function getClosingTime(): ?\DateTimeInterface
    {
        return $this->closing_time;
    }

    public function setClosingTime(\DateTimeInterface $closing_time): static
    {
        $this->closing_time = $closing_time;

        return $this;
    }

    public function getStartBrakTime(): ?\DateTimeInterface
    {
        return $this->start_break_time;
    }

    public function setStartBrakTime(\DateTimeInterface $start_break_time): static
    {
        $this->start_break_time = $start_break_time;

        return $this;
    }

    public function getEndOfBreak(): ?\DateTimeInterface
    {
        return $this->end_of_break;
    }

    public function setEndOfBreak(\DateTimeInterface $end_of_break): static
    {
        $this->end_of_break = $end_of_break;

        return $this;
    }

    public function getScheduler(): ?User
    {
        return $this->scheduler;
    }

    public function setScheduler(?User $scheduler): static
    {
        $this->scheduler = $scheduler;

        return $this;
    }
}
