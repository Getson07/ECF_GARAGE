<?php

namespace App\Entity;

use App\Repository\CarCaracteristicRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarCaracteristicRepository::class)]
class CarCaracteristic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $year_of_launch = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $origin = null;

    #[ORM\Column(length: 100)]
    private ?string $technichal_control = null;

    #[ORM\Column]
    private ?bool $first_hand = null;

    #[ORM\Column(length: 20)]
    private ?string $energy = null;

    #[ORM\Column(length: 100)]
    private ?string $gearbox = null;

    #[ORM\Column(length: 20)]
    private ?string $color = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $number_of_doors = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $number_of_seats = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $length = null;

    #[ORM\Column(nullable: true)]
    private ?int $trunk_volume = null;

    #[ORM\OneToOne(inversedBy: 'characteristics', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $related_car = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYearOfLaunch(): ?\DateTimeInterface
    {
        return $this->year_of_launch;
    }

    public function setYearOfLaunch(\DateTimeInterface $year_of_launch): static
    {
        $this->year_of_launch = $year_of_launch;

        return $this;
    }

    public function getOrigin(): ?string
    {
        return $this->origin;
    }

    public function setOrigin(?string $origin): static
    {
        $this->origin = $origin;

        return $this;
    }

    public function getTechnichalControl(): ?string
    {
        return $this->technichal_control;
    }

    public function setTechnichalControl(string $technichal_control): static
    {
        $this->technichal_control = $technichal_control;

        return $this;
    }

    public function isFirstHand(): ?bool
    {
        return $this->first_hand;
    }

    public function setFirstHand(bool $first_hand): static
    {
        $this->first_hand = $first_hand;

        return $this;
    }

    public function getEnergy(): ?string
    {
        return $this->energy;
    }

    public function setEnergy(string $energy): static
    {
        $this->energy = $energy;

        return $this;
    }

    public function getGearbox(): ?string
    {
        return $this->gearbox;
    }

    public function setGearbox(string $gearbox): static
    {
        $this->gearbox = $gearbox;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getNumberOfDoors(): ?int
    {
        return $this->number_of_doors;
    }

    public function setNumberOfDoors(int $number_of_doors): static
    {
        $this->number_of_doors = $number_of_doors;

        return $this;
    }

    public function getNumberOfSeats(): ?int
    {
        return $this->number_of_seats;
    }

    public function setNumberOfSeats(int $number_of_seats): static
    {
        $this->number_of_seats = $number_of_seats;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): static
    {
        $this->length = $length;

        return $this;
    }

    public function getTrunkVolume(): ?int
    {
        return $this->trunk_volume;
    }

    public function setTrunkVolume(?int $trunk_volume): static
    {
        $this->trunk_volume = $trunk_volume;

        return $this;
    }

    public function getRelatedCar(): ?Car
    {
        return $this->related_car;
    }

    public function setRelatedCar(Car $related_car): static
    {
        $this->related_car = $related_car;

        return $this;
    }
}
