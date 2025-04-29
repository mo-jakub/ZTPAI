<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "admins")]
class Admin
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "admins")]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id", nullable: false, onDelete: "NO ACTION")]
    private $user;

    #[ORM\ManyToOne(targetEntity: Roles::class, inversedBy: "admins")]
    #[ORM\JoinColumn(name: "id_role", referencedColumnName: "id", nullable: false, onDelete: "NO ACTION")]
    private $roles;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRoles(): ?Roles
    {
        return $this->roles;
    }

    public function setRoles(?Roles $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
}