<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "comments")]
class comments
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $comment;

    #[ORM\Column(type: "datetime", nullable: false, options: ["default"=>"NOW()"])]
    private $date;

    #[ORM\ManyToOne(targetEntity: \users::class, inversedBy: "comments")]
    #[ORM\JoinColumn(name: "id_user",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $users;

    #[ORM\ManyToOne(targetEntity: \books::class, inversedBy: "comments")]
    #[ORM\JoinColumn(name: "id_book",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
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

    public function getUsers(): ?users
    {
        return $this->users;
    }

    public function setUsers(?users $users): static
    {
        $this->users = $users;

        return $this;
    }

    public function getBooks(): ?books
    {
        return $this->books;
    }

    public function setBooks(?books $books): static
    {
        $this->books = $books;

        return $this;
    }
}