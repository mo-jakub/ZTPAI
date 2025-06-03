<?php

namespace App\Service;

use App\Entity\Tags;
use App\Entity\BookTags;
use Doctrine\ORM\EntityManagerInterface;

class TagService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllTags(): array
    {
        return $this->entityManager->getRepository(Tags::class)->findAll();
    }

    public function getTagById(int $id): ?Tags
    {
        return $this->entityManager->getRepository(Tags::class)->find($id);
    }

    public function getBooksByTag(Tags $tag): array
    {
        $bookTags = $this->entityManager->getRepository(BookTags::class)->findBy(['tags' => $tag]);
        $books = [];
        foreach ($bookTags as $ba) {
            $book = $ba->getBooks();
            if ($book) {
                $books[] = [
                    'id' => $book->getId(),
                    'title' => $book->getTitle(),
                    'description' => $book->getDescription(),
                    'cover' => $book->getCover(),
                ];
            }
        }
        return $books;
    }

    public function addTag(string $tagName): Tags
    {
        $tag = new Tags();
        $tag->setTag($tagName);

        $this->entityManager->persist($tag);
        $this->entityManager->flush();

        return $tag;
    }

    public function deleteTag(Tags $tag): void
    {
        $bookTags = $this->entityManager->getRepository(BookTags::class)->findBy(['tags' => $tag]);
        foreach ($bookTags as $bt) {
            $this->entityManager->remove($bt);
        }

        $this->entityManager->remove($tag);
        $this->entityManager->flush();
    }
}