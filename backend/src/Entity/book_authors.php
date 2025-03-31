<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "book_authors")]
class book_authors
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \books::class, inversedBy: "bookAuthors")]
    #[ORM\JoinColumn(name: "id_book",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $books;

    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \authors::class, inversedBy: "bookAuthors")]
    #[ORM\JoinColumn(name: "id_author",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $authors;

    public function getBooks(): ?books
    {
        return $this->books;
    }

    public function setBooks(books $books): static
    {
        $this->books = $books;

        return $this;
    }

    public function getAuthors(): ?authors
    {
        return $this->authors;
    }

    public function setAuthors(authors $authors): static
    {
        $this->authors = $authors;

        return $this;
    }
}