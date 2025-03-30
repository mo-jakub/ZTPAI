<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    private array $books = [
        ['id' => 1, 'title' => 'Hobbit', 'author' =>'Tolkien'],
        ['id' => 2, 'title' => 'Lord of the Rings', 'author' =>'Tolkien'],
    ];

    #[Route('/api/books', name: 'get_books', methods: ['GET'])]
    public function getBooks(): JsonResponse
    {
        return $this->json($this->books);
    }

    #[Route('/api/books', name: 'add_book', methods: ['POST'])]
    public function addBooks(): JsonResponse
    {
        $newBook = [
            'id' => count($this->books) + 1,
            'title' => 'New Book',
            'author' => 'Jan Kowalski',
        ];

        $this->books[] = $newBook;

        return $this->json(['message' => 'Book added successfully', 'user' => $newBook], 201);
    }

    #[Route('/api/books/{id}', name: 'get_book_by_id', methods: ['GET'])]
    public function getBookById(int $id): JsonResponse
    {
        $book = $this->findBookById($id);
        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        return $this->json($book);
    }

    #[Route('/api/books/{id}', name: 'delete_book_by_id', methods: ['DELETE'])]
    public function deleteBookById(int $id): JsonResponse
    {
        $book = $this->findBookById($id);
        if (!$book) {
            return $this->json(['error' => 'Book not found'], 404);
        }

        $this->books = array_filter($this->books, fn($u) => $u['id'] !== $id);
        $this->books = array_values($this->books);

        return $this->json(['message' => 'Book deleted successfully']);
    }

    private function findBookById(int $id): ?array
    {
        foreach ($this->books as $book) {
            if ($book['id'] === $id) {
                return $book;
            }
        }
        return null;
    }
}