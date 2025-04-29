<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "comments")]
class Comments
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $comment;

    #[ORM\Column(type: "datetime", nullable: false)]
    private $date;

    #[ORM\ManyToOne(targetEntity: \App\Entity\User::class, inversedBy: "comments")]
    #[ORM\JoinColumn(name: "id_user", referencedColumnName: "id", nullable: false, onDelete: "NO ACTION")]
    private $user;

    #[ORM\ManyToOne(targetEntity: \App\Entity\Books::class, inversedBy: "comments")]
    #[ORM\JoinColumn(name: "id_book", referencedColumnName: "id", nullable: false, onDelete: "NO ACTION")]
    private $books;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

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

    public function getBooks(): ?Books
    {
        return $this->books;
    }

    public function setBooks(?Books $books): static
    {
        $this->books = $books;

        return $this;
    }
}