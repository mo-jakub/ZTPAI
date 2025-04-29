<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "Sessions")]
#[ORM\UniqueConstraint(name: "Sessions_session_token_key", columns: ["session_token"])]
class Sessions
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $session_token;

    #[ORM\Column(type: "datetime", nullable: false)]
    private $expiration_date;

    #[ORM\ManyToOne(targetEntity: \user::class, inversedBy: "Sessions")]
    #[ORM\JoinColumn(name: "id_user",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $user;

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

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }
}