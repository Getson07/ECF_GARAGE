<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $sender_firstname = null;

    #[ORM\Column(length: 20)]
    private ?string $sender_lastname = null;

    #[ORM\Column(length: 100)]
    private ?string $sender_email = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    private ?Client $client = null;

    public function getId(): ?int
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
