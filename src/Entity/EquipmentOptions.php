<?php

namespace App\Entity;

use App\Repository\EquipmentOptionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EquipmentOptionsRepository::class)]
class EquipmentOptions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY)]
    #[Assert\NotBlank(message: "Veuiller entrer une valeur s'il vous plaît")]
    #[Assert\NotNull()]
    private array $exterior_and_chassis = [];

    #[ORM\Column(type: Types::ARRAY)]
    #[Assert\NotBlank(message: "Veuiller entrer une valeur s'il vous plaît")]
    #[Assert\NotNull()]
    private array $interior = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $security = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $security_lock = null;

    #[ORM\OneToOne(inversedBy: 'equipmentOptions', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $related_car = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExteriorAndChassis(): array
    {
        return $this->exterior_and_chassis;
    }

    public function setExteriorAndChassis(array $exterior_and_chassis): static
    {
        $this->exterior_and_chassis = $exterior_and_chassis;

        return $this;
    }

    public function getInterior(): array
    {
        return $this->interior;
    }

    public function setInterior(array $interior): static
    {
        $this->interior = $interior;

        return $this;
    }

    public function getSecurity(): array
    {
        return $this->security;
    }

    public function setSecurity(array $security): static
    {
        $this->security = $security;

        return $this;
    }

    public function getSecurityLock(): ?string
    {
        return $this->security_lock;
    }

    public function setSecurityLock(?string $security_lock): static
    {
        $this->security_lock = $security_lock;

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
