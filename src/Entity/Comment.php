<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Veuillez saisir une valeur")]
    #[Assert\NoSuspiciousCharacters()]
    private ?string $message = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $rate = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Client $client = null;

    #[ORM\ManyToOne]
    private ?User $user = null;

    #[ORM\Column(options: ['default'=> false])]
    private ?bool $isValidate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getClient(): ?CLient
    {
        return $this->client;
    }

    public function setClient(?CLient $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function isIsValidate(): ?bool
    {
        return $this->isValidate;
    }

    public function setIsValidate(bool $isValidate): static
    {
        $this->isValidate = $isValidate;

        return $this;
    }
}
