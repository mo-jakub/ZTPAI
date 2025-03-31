<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "admins")]
class admins
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\ManyToOne(targetEntity: \users::class, inversedBy: "admins")]
    #[ORM\JoinColumn(name: "id_user",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $users;

    #[ORM\ManyToOne(targetEntity: \roles::class, inversedBy: "admins")]
    #[ORM\JoinColumn(name: "id_role",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $roles;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getRoles(): ?roles
    {
        return $this->roles;
    }

    public function setRoles(?roles $roles): static
    {
        $this->roles = $roles;

        return $this;
    }
}