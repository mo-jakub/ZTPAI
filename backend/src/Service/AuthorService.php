<?php

namespace App\Service;

use App\Entity\Authors;
use App\Entity\BookAuthors;
use App\Entity\Books;
use Doctrine\ORM\EntityManagerInterface;

class AuthorService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllAuthors(): array
    {
        return $this->entityManager->getRepository(Authors::class)->findAll();
    }

    public function getAuthorById(int $id): ?Authors
    {
        return $this->entityManager->getRepository(Authors::class)->find($id);
    }

    public function getBooksByAuthor(Authors $author): array
    {
        $bookAuthors = $this->entityManager->getRepository(BookAuthors::class)->findBy(['authors' => $author]);
        $books = [];
        foreach ($bookAuthors as $ba) {
            $book = $ba->getBooks();
            if ($book) {
                $books[] = $book;
            }
        }
        return $books;
    }

    public function addAuthor(string $authorName): Authors
    {
        $author = new Authors();
        $author->setAuthor($authorName);

        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return $author;
    }

    public function deleteAuthor(Authors $author): void
    {
        $bookAuthors = $this->entityManager->getRepository(BookAuthors::class)->findBy(['authors' => $author]);
        foreach ($bookAuthors as $ba) {
            $this->entityManager->remove($ba);
        }

        $this->entityManager->remove($author);
        $this->entityManager->flush();
    }
}