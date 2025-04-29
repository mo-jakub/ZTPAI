<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "book_genres")]
class BookGenres
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \Books::class, inversedBy: "bookGenres")]
    #[ORM\JoinColumn(name: "id_book",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $books;

    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \Genres::class, inversedBy: "bookGenres")]
    #[ORM\JoinColumn(name: "id_genre",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $genres;

    public function getBooks(): ?Books
    {
        return $this->books;
    }

    public function setBooks(Books $books): static
    {
        $this->books = $books;

        return $this;
    }

    public function getGenres(): ?Genres
    {
        return $this->genres;
    }

    public function setGenres(Genres $genres): static
    {
        $this->genres = $genres;

        return $this;
    }
}