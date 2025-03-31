<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "books")]
#[ORM\UniqueConstraint(name: "books_title_description_key", columns: ["title","description"])]
class books
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $title;

    #[ORM\Column(type: "string", length: 255, nullable: false)]
    private $description;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private $cover;

    #[ORM\OneToOne(targetEntity: \book_tags::class, mappedBy: "books")]
    private $bookTags;

    #[ORM\OneToOne(targetEntity: \book_genres::class, mappedBy: "books")]
    private $bookGenres;

    #[ORM\OneToOne(targetEntity: \book_authors::class, mappedBy: "books")]
    private $bookAuthors;

    #[ORM\OneToMany(targetEntity: \comments::class, mappedBy: "books")]
    private $comments;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): static
    {
        $this->cover = $cover;

        return $this;
    }

    public function getBookTags(): ?book_tags
    {
        return $this->bookTags;
    }

    public function setBookTags(?book_tags $bookTags): static
    {
        // unset the owning side of the relation if necessary
        if ($bookTags === null && $this->bookTags !== null) {
            $this->bookTags->setBooks(null);
        }

        // set the owning side of the relation if necessary
        if ($bookTags !== null && $bookTags->getBooks() !== $this) {
            $bookTags->setBooks($this);
        }

        $this->bookTags = $bookTags;

        return $this;
    }

    public function getBookGenres(): ?book_genres
    {
        return $this->bookGenres;
    }

    public function setBookGenres(?book_genres $bookGenres): static
    {
        // unset the owning side of the relation if necessary
        if ($bookGenres === null && $this->bookGenres !== null) {
            $this->bookGenres->setBooks(null);
        }

        // set the owning side of the relation if necessary
        if ($bookGenres !== null && $bookGenres->getBooks() !== $this) {
            $bookGenres->setBooks($this);
        }

        $this->bookGenres = $bookGenres;

        return $this;
    }

    public function getBookAuthors(): ?book_authors
    {
        return $this->bookAuthors;
    }

    public function setBookAuthors(?book_authors $bookAuthors): static
    {
        // unset the owning side of the relation if necessary
        if ($bookAuthors === null && $this->bookAuthors !== null) {
            $this->bookAuthors->setBooks(null);
        }

        // set the owning side of the relation if necessary
        if ($bookAuthors !== null && $bookAuthors->getBooks() !== $this) {
            $bookAuthors->setBooks($this);
        }

        $this->bookAuthors = $bookAuthors;

        return $this;
    }

    /**
     * @return Collection<int, comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setBooks($this);
        }

        return $this;
    }

    public function removeComment(comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBooks() === $this) {
                $comment->setBooks(null);
            }
        }

        return $this;
    }
}