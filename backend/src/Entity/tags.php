<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "tags")]
#[ORM\UniqueConstraint(name: "tags_tag_key", columns: ["tag"])]
class Tags
{
    #[ORM\Id]
    #[ORM\Column(type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private $id;

    #[ORM\Column(type: "string", length: 100, nullable: false)]
    private $tag;

    #[ORM\OneToOne(targetEntity: \BookTags::class, mappedBy: "tags")]
    private $bookTags;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): static
    {
        $this->tag = $tag;

        return $this;
    }

    public function getBookTags(): ?BookTags
    {
        return $this->bookTags;
    }

    public function setBookTags(?BookTags $bookTags): static
    {
        // unset the owning side of the relation if necessary
        if ($bookTags === null && $this->bookTags !== null) {
            $this->bookTags->setTags(null);
        }

        // set the owning side of the relation if necessary
        if ($bookTags !== null && $bookTags->getTags() !== $this) {
            $bookTags->setTags($this);
        }

        $this->bookTags = $bookTags;

        return $this;
    }
}