<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "book_authors")]
class BookAuthors
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \Books::class, inversedBy: "bookAuthors")]
    #[ORM\JoinColumn(name: "id_book",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $books;

    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \Authors::class, inversedBy: "bookAuthors")]
    #[ORM\JoinColumn(name: "id_author",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $authors;

    public function getBooks(): ?Books
    {
        return $this->books;
    }

    public function setBooks(Books $books): static
    {
        $this->books = $books;

        return $this;
    }

    public function getAuthors(): ?Authors
    {
        return $this->authors;
    }

    public function setAuthors(Authors $authors): static
    {
        $this->authors = $authors;

        return $this;
    }
}