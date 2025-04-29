<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "authors")]
class Authors
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $author;

    #[ORM\OneToOne(targetEntity: \BookAuthors::class, mappedBy: "authors")]
    private $bookAuthors;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getBookAuthors(): ?BookAuthors
    {
        return $this->bookAuthors;
    }

    public function setBookAuthors(?BookAuthors $bookAuthors): static
    {
        // unset the owning side of the relation if necessary
        if ($bookAuthors === null && $this->bookAuthors !== null) {
            $this->bookAuthors->setAuthors(null);
        }

        // set the owning side of the relation if necessary
        if ($bookAuthors !== null && $bookAuthors->getAuthors() !== $this) {
            $bookAuthors->setAuthors($this);
        }

        $this->bookAuthors = $bookAuthors;

        return $this;
    }
}