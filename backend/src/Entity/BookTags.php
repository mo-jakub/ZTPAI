<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "book_tags")]
class BookTags
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \Books::class, inversedBy: "bookTags")]
    #[ORM\JoinColumn(name: "id_book",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $books;

    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \Tags::class, inversedBy: "bookTags")]
    #[ORM\JoinColumn(name: "id_tag",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $tags;

    public function getBooks(): ?Books
    {
        return $this->books;
    }

    public function setBooks(Books $books): static
    {
        $this->books = $books;

        return $this;
    }

    public function getTags(): ?Tags
    {
        return $this->tags;
    }

    public function setTags(Tags $tags): static
    {
        $this->tags = $tags;

        return $this;
    }
}