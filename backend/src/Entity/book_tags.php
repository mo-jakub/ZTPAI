<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "book_tags")]
class book_tags
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \books::class, inversedBy: "bookTags")]
    #[ORM\JoinColumn(name: "id_book",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $books;

    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: \tags::class, inversedBy: "bookTags")]
    #[ORM\JoinColumn(name: "id_tag",
            referencedColumnName: "id",
            nullable: false,
            onDelete: "NO ACTION")]
    private $tags;

    public function getBooks(): ?books
    {
        return $this->books;
    }

    public function setBooks(books $books): static
    {
        $this->books = $books;

        return $this;
    }

    public function getTags(): ?tags
    {
        return $this->tags;
    }

    public function setTags(tags $tags): static
    {
        $this->tags = $tags;

        return $this;
    }
}