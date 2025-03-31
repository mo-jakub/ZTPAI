<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "sessions")]
#[ORM\UniqueConstraint(name: "sessions_session_token_key", columns: ["session_token"])]
class sessions
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $session_token;

    #[ORM\Column(type: "datetime", nullable: false)]
    private $expiration_date;

    #[ORM\ManyToOne(targetEntity: \users::class, inversedBy: "sessions")]
    #[ORM\JoinColumn(name: "id_user",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $users;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSessionToken(): ?string
    {
        return $this->session_token;
    }

    public function setSessionToken(string $session_token): static
    {
        $this->session_token = $session_token;

        return $this;
    }

    public function getExpirationDate(): ?\DateTimeInterface
    {
        return $this->expiration_date;
    }

    public function setExpirationDate(\DateTimeInterface $expiration_date): static
    {
        $this->expiration_date = $expiration_date;

        return $this;
    }

    public function getUsers(): ?users
    {
        return $this->users;
    }

    public function setUsers(?users $users): static
    {
        $this->users = $users;

        return $this;
    }
}