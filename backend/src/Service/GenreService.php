<?php

namespace App\Service;

use App\Entity\Genres;
use App\Entity\BookGenres;
use Doctrine\ORM\EntityManagerInterface;

class GenreService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getAllGenres(): array
    {
        return $this->entityManager->getRepository(Genres::class)->findAll();
    }

    public function getGenreById(int $id): ?Genres
    {
        return $this->entityManager->getRepository(Genres::class)->find($id);
    }

    public function getBooksByGenre(Genres $genre): array
    {
        $bookGenres = $this->entityManager->getRepository(BookGenres::class)->findBy(['genres' => $genre]);
        $books = [];
        foreach ($bookGenres as $ba) {
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

    public function addGenre(string $genreName): Genres
    {
        $genre = new Genres();
        $genre->setGenre($genreName);

        $this->entityManager->persist($genre);
        $this->entityManager->flush();

        return $genre;
    }

    public function deleteGenre(Genres $genre): void
    {
        $bookGenres = $this->entityManager->getRepository(BookGenres::class)->findBy(['genres' => $genre]);
        foreach ($bookGenres as $bg) {
            $this->entityManager->remove($bg);
        }

        $this->entityManager->remove($genre);
        $this->entityManager->flush();
    }
}