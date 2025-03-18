<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    #[Route('/api/books', name: 'get_books', methods: ['GET'])]
    public function getBooks(): JsonResponse
    {
        $books = [
        ['id' => 1, 'name' => 'Hobbit', 'author' =>'Tolkien'],
        ['id' => 2, 'name' => 'Lord of the Rings', 'author' =>'Tolkien'],
        ];
        return $this->json($books);
    }

    #[Route('/api/books/{id}', name: 'get_book_by_id', methods: ['GET'])]
    public function getBookById(int $id): JsonResponse
    {
        $books = [
        1 => ['id' => 1, 'name' => 'Hobbit', 'author' =>'Tolkien'],
        2 => ['id' => 2, 'name' => 'Lord of the Rings', 'author' =>'Tolkien'],
        ];
        if (!isset($books[$id])) {
            return $this->json(['error' => 'User not found'], 404);
        }
        return $this->json($books[$id]);
    }
}