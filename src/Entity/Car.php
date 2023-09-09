<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique:true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Veuiller entrer une valeur s'il vous plaît")]
    #[Assert\Length(min:3, minMessage:"Le nom de marquage doit faire plus de {{ limit }} caratères")]
    private ?string $name = null;

    #[ORM\Column(type: Types::JSON)]
    #[Assert\NotBlank(message: "Veuiller entrer une valeur s'il vous plaît")]
    #[Assert\NotNull(message: "Ce champ doit contenir au moins une image")]
    private array $images = [];

    #[ORM\Column]
    #[Assert\NotBlank(message: "Veuiller entrer une valeur s'il vous plaît")]
    #[Assert\Positive(message: "Le prix doit être supérieur à 0")]
    private ?int $price = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $fiscal_power = null;

    #[ORM\Column(length: 20)]
    private ?string $engine_power = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $euro_standard = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $crit_air = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $combined_consumption = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $co2_emission = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $posted_at = null;

    #[ORM\ManyToOne(inversedBy: 'posted_cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $poster = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Model $model = null;

    #[ORM\OneToOne(mappedBy: 'related_car', cascade: ['persist', 'remove'])]
    private ?CarCaracteristic $characteristics = null;

    #[ORM\OneToOne(mappedBy: 'related_car', cascade: ['persist', 'remove'])]
    private ?EquipmentOptions $equipmentOptions = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getFiscalPower(): ?string
    {
        return $this->fiscal_power;
    }

    public function setFiscalPower(?string $fiscal_power): static
    {
        $this->fiscal_power = $fiscal_power;

        return $this;
    }

    public function getEnginePower(): ?string
    {
        return $this->engine_power;
    }

    public function setEnginePower(string $engine_power): static
    {
        $this->engine_power = $engine_power;

        return $this;
    }

    public function getEuroStandard(): ?string
    {
        return $this->euro_standard;
    }

    public function setEuroStandard(?string $euro_standard): static
    {
        $this->euro_standard = $euro_standard;

        return $this;
    }

    public function getCritAir(): ?string
    {
        return $this->crit_air;
    }

    public function setCritAir(?string $crit_air): static
    {
        $this->crit_air = $crit_air;

        return $this;
    }

    public function getCombinedConsumption(): ?string
    {
        return $this->combined_consumption;
    }

    public function setCombinedConsumption(?string $combined_consumption): static
    {
        $this->combined_consumption = $combined_consumption;

        return $this;
    }

    public function getCo2Emission(): ?string
    {
        return $this->co2_emission;
    }

    public function setCo2Emission(?string $co2_emission): static
    {
        $this->co2_emission = $co2_emission;

        return $this;
    }

    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->posted_at;
    }

    public function setPostedAt(\DateTimeInterface $posted_at): static
    {
        $this->posted_at = $posted_at;

        return $this;
    }

    public function getPoster(): ?User
    {
        return $this->poster;
    }

    public function setPoster(?User $poster): static
    {
        $this->poster = $poster;

        return $this;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getCharacteristics(): ?CarCaracteristic
    {
        return $this->characteristics;
    }

    public function setCharacteristics(CarCaracteristic $characteristics): static
    {
        // set the owning side of the relation if necessary
        if ($characteristics->getRelatedCar() !== $this) {
            $characteristics->setRelatedCar($this);
        }

        $this->characteristics = $characteristics;

        return $this;
    }

    public function getEquipmentOptions(): ?EquipmentOptions
    {
        return $this->equipmentOptions;
    }

    public function setEquipmentOptions(EquipmentOptions $equipmentOptions): static
    {
        // set the owning side of the relation if necessary
        if ($equipmentOptions->getRelatedCar() !== $this) {
            $equipmentOptions->setRelatedCar($this);
        }

        $this->equipmentOptions = $equipmentOptions;

        return $this;
    }
}
