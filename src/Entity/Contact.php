<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique:true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?string $id = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Veuiller entrer une valeur s'il vous plaît")]
    #[Assert\Length(min:3, minMessage:"Le nom de marquage doit faire plus de {{ limit }} caratères")]
    #[Assert\Regex("/[^[:punct:]]/g", message:"Pour les nom composés veuillez les collés avec majuscule")]
    private ?string $sender_firstname = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: "Veuiller entrer une valeur s'il vous plaît")]
    #[Assert\Length(min:3, minMessage:"Le nom de marquage doit faire plus de {{ limit }} caratères")]
    #[Assert\Regex("/[^[:punct:]]/g", message:"Pour les nom composés veuillez les collés avec majuscule")]
    private ?string $sender_lastname = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Veuiller entrer une valeur s'il vous plaît")]
    #[Assert\Email(mode: "strict")]
    private ?string $sender_email = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Veuiller entrer une valeur s'il vous plaît")]
    #[Assert\Length(min:3, minMessage:"Le nom de marquage doit faire plus de {{ limit }} caratères")]
    #[Assert\NoSuspiciousCharacters()]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    private ?Client $client = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getSenderFirstname(): ?string
    {
        return $this->sender_firstname;
    }

    public function setSenderFirstname(string $sender_firstname): static
    {
        $this->sender_firstname = $sender_firstname;

        return $this;
    }

    public function getSenderLastname(): ?string
    {
        return $this->sender_lastname;
    }

    public function setSenderLastname(string $sender_lastname): static
    {
        $this->sender_lastname = $sender_lastname;

        return $this;
    }

    public function getSenderEmail(): ?string
    {
        return $this->sender_email;
    }

    public function setSenderEmail(string $sender_email): static
    {
        $this->sender_email = $sender_email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }
}
