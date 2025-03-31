<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "book_genres")]
class book_genres
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \books::class, inversedBy: "bookGenres")]
    #[ORM\JoinColumn(name: "id_book",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $books;

    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \genres::class, inversedBy: "bookGenres")]
    #[ORM\JoinColumn(name: "id_genre",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $genres;

    public function getBooks(): ?books
    {
        return $this->books;
    }

    public function setBooks(books $books): static
    {
        $this->books = $books;

        return $this;
    }

    public function getGenres(): ?genres
    {
        return $this->genres;
    }

    public function setGenres(genres $genres): static
    {
        $this->genres = $genres;

        return $this;
    }
}