<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "roles")]
#[ORM\UniqueConstraint(name: "roles_role_key", columns: ["role"])]
class roles
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", length: 100, nullable: false)]
    private $role;

    #[ORM\OneToMany(targetEntity: \admins::class, mappedBy: "roles")]
    private $admins;

    public function __construct()
    {
        $this->admins = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, admins>
     */
    public function getAdmins(): Collection
    {
        return $this->admins;
    }

    public function addAdmin(admins $admin): static
    {
        if (!$this->admins->contains($admin)) {
            $this->admins->add($admin);
            $admin->setRoles($this);
        }

        return $this;
    }

    public function removeAdmin(admins $admin): static
    {
        if ($this->admins->removeElement($admin)) {
            // set the owning side to null (unless already changed)
            if ($admin->getRoles() === $this) {
                $admin->setRoles(null);
            }
        }

        return $this;
    }
}