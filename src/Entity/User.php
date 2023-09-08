<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank(message: "Veuiller entrer une valeur s'il vous plaît")]
    #[Assert\Email(mode: "strict")]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Veuiller entrer une valeur s'il vous plaît")]
    #[Assert\Length(min:3, minMessage:"Le nom de marquage doit faire plus de {{ limit }} caratères")]
    #[Assert\Regex("/[^[:punct:]]/g", message:"Pour les nom composés veuillez les collés avec majuscule")]
    private ?string $firstname = null;

    #[ORM\Column(length: 20)]
    private ?string $lastname = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: "Veuiller choisir une valeur s'il vous plaît")]
    #[Assert\Choice(["Homme", "Femme"], multiple: false)]
    private ?string $gender = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_of_birth = null;

    #[ORM\OneToMany(mappedBy: 'poster', targetEntity: Car::class)]
    private Collection $posted_cars;

    #[ORM\OneToMany(mappedBy: 'scheduler', targetEntity: OpeningHours::class)]
    private Collection $schedules;

    public function __construct()
    {
        $this->posted_cars = new ArrayCollection();
        $this->schedules = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(\DateTimeInterface $date_of_birth): static
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getPostedCars(): Collection
    {
        return $this->posted_cars;
    }

    public function addPostedCar(Car $postedCar): static
    {
        if (!$this->posted_cars->contains($postedCar)) {
            $this->posted_cars->add($postedCar);
            $postedCar->setPoster($this);
        }

        return $this;
    }

    public function removePostedCar(Car $postedCar): static
    {
        if ($this->posted_cars->removeElement($postedCar)) {
            // set the owning side to null (unless already changed)
            if ($postedCar->getPoster() === $this) {
                $postedCar->setPoster(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OpeningHours>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    public function addSchedule(OpeningHours $schedule): static
    {
        if (!$this->schedules->contains($schedule)) {
            $this->schedules->add($schedule);
            $schedule->setScheduler($this);
        }

        return $this;
    }

    public function removeSchedule(OpeningHours $schedule): static
    {
        if ($this->schedules->removeElement($schedule)) {
            // set the owning side to null (unless already changed)
            if ($schedule->getScheduler() === $this) {
                $schedule->setScheduler(null);
            }
        }

        return $this;
    }
}
