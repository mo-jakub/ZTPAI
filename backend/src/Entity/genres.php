<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "genres")]
#[ORM\UniqueConstraint(name: "genres_genre_key", columns: ["genre"])]
class Genres
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", length: 100, nullable: false)]
    private $genre;

    #[ORM\OneToOne(targetEntity: \BookGenres::class, mappedBy: "genres")]
    private $bookGenres;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): static
    {
        $this->genre = $genre;

        return $this;
    }

    public function getBookGenres(): ?BookGenres
    {
        return $this->bookGenres;
    }

    public function setBookGenres(?BookGenres $bookGenres): static
    {
        // unset the owning side of the relation if necessary
        if ($bookGenres === null && $this->bookGenres !== null) {
            $this->bookGenres->setGenres(null);
        }

        // set the owning side of the relation if necessary
        if ($bookGenres !== null && $bookGenres->getGenres() !== $this) {
            $bookGenres->setGenres($this);
        }

        $this->bookGenres = $bookGenres;

        return $this;
    }
}