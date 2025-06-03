<?php

namespace App\Service;

use App\Entity\Books;
use App\Entity\BookAuthors;
use App\Entity\BookGenres;
use App\Entity\BookTags;
use Doctrine\ORM\EntityManagerInterface;

class BookService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getBooks(?string $search = null): array
    {
        $repo = $this->entityManager->getRepository(Books::class);

        if ($search) {
            $qb = $repo->createQueryBuilder('b');
            $qb->where('LOWER(b.title) LIKE :search')
                ->setParameter('search', '%' . strtolower($search) . '%');
            return $qb->getQuery()->getResult();
        }
        return $repo->findAll();
    }

    public function getBookById(int $id): ?Books
    {
        return $this->entityManager->getRepository(Books::class)->find($id);
    }

    public function getBookDetails(Books $book): array
    {
        $bookAuthors = $this->entityManager->getRepository(BookAuthors::class)->findBy(['books' => $book]);
        $authors = [];
        foreach ($bookAuthors as $ba) {
            $author = $ba->getAuthors();
            if ($author) {
                $authors[] = [
                    'id' => $author->getId(),
                    'author' => $author->getAuthor(),
                ];
            }
        }

        $bookGenres = $this->entityManager->getRepository(BookGenres::class)->findBy(['books' => $book]);
        $genres = [];
        foreach ($bookGenres as $bg) {
            $genre = $bg->getGenres();
            if ($genre) {
                $genres[] = [
                    'id' => $genre->getId(),
                    'genre' => $genre->getGenre(),
                ];
            }
        }

        $bookTags = $this->entityManager->getRepository(BookTags::class)->findBy(['books' => $book]);
        $tags = [];
        foreach ($bookTags as $bt) {
            $tag = $bt->getTags();
            if ($tag) {
                $tags[] = [
                    'id' => $tag->getId(),
                    'tag' => $tag->getTag(),
                ];
            }
        }

        return [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'description' => $book->getDescription(),
            'cover' => $book->getCover(),
            'authors' => $authors,
            'genres' => $genres,
            'tags' => $tags,
        ];
    }

    public function addBook(array $data): Books
    {
        $newBook = new Books();
        $newBook->setTitle($data['title'] ?? 'Default Title');
        $newBook->setDescription($data['description'] ?? 'Default Description');
        $newBook->setCover($data['cover'] ?? null);

        $this->entityManager->persist($newBook);
        $this->entityManager->flush();

        return $newBook;
    }

    public function deleteBook(Books $book): void
    {
        $this->entityManager->remove($book);
        $this->entityManager->flush();
    }
}