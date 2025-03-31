<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "users")]
#[ORM\UniqueConstraint(name: "users_username_key", columns: ["username"])]
#[ORM\UniqueConstraint(name: "users_email_key", columns: ["email"])]
class users
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", length: 100, nullable: false)]
    private $username;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $email;

    #[ORM\Column(type: "string", length: 100, nullable: false)]
    private $hashed_password;

    #[ORM\OneToMany(targetEntity: \admins::class, mappedBy: "users")]
    private $admins;

    #[ORM\OneToMany(targetEntity: \sessions::class, mappedBy: "users")]
    private $sessions;

    #[ORM\OneToMany(targetEntity: \comments::class, mappedBy: "users")]
    private $comments;

    public function __construct()
    {
        $this->admins = new ArrayCollection();
        $this->sessions = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
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

    public function getHashedPassword(): ?string
    {
        return $this->hashed_password;
    }

    public function setHashedPassword(string $hashed_password): static
    {
        $this->hashed_password = $hashed_password;

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
            $admin->setUsers($this);
        }

        return $this;
    }

    public function removeAdmin(admins $admin): static
    {
        if ($this->admins->removeElement($admin)) {
            // set the owning side to null (unless already changed)
            if ($admin->getUsers() === $this) {
                $admin->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, sessions>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(sessions $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setUsers($this);
        }

        return $this;
    }

    public function removeSession(sessions $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getUsers() === $this) {
                $session->setUsers(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setUsers($this);
        }

        return $this;
    }

    public function removeComment(comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUsers() === $this) {
                $comment->setUsers(null);
            }
        }

        return $this;
    }
}