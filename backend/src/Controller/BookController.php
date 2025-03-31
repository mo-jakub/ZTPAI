<?php

namespace App\Controller;

use App\Entity\books;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/books', name: 'get_books', methods: ['GET'])]
    public function getBooks(): JsonResponse
    {
        $books = $this->entityManager->getRepository(books::class)->findAll();

        $data = array_map(function (books $book) {
            return [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'description' => $book->getDescription(),
                'cover' => $book->getCover(),
            ];
        }, $books);

        return $this->json($data);
    }

    #[Route('/api/books/{id}', name: 'get_book_by_id', methods: ['GET'])]
    public function getBookById(int $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(books::class)->find($id);

        if (!$book) {
            return $this->json(['error' => 'No book found for id ' . $id], 404);
        }

        $data = [
            'id' => $book->getId(),
            'title' => $book->getTitle(),
            'description' => $book->getDescription(),
            'cover' => $book->getCover(),
        ];

        return $this->json($data);
    }

    #[Route('/api/books', name: 'add_book', methods: ['POST'])]
    public function addBooks(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $newBook = new books();
        $newBook->setTitle($data['title'] ?? 'Default Title');
        $newBook->setDescription($data['description'] ?? 'Default Description');
        $newBook->setCover($data['cover'] ?? null);

        $this->entityManager->persist($newBook);
        $this->entityManager->flush();

        return $this->json(['message' => 'Saved new book with id ' . $newBook->getId(), 'book' => [
            'id' => $newBook->getId(),
            'title' => $newBook->getTitle(),
            'description' => $newBook->getDescription(),
            'cover' => $newBook->getCover(),
        ]], 201);
    }

    #[Route('/api/books/{id}', name: 'delete_book_by_id', methods: ['DELETE'])]
    public function deleteBookById(int $id): JsonResponse
    {
        $book = $this->entityManager->getRepository(books::class)->find($id);

        if (!$book) {
            return $this->json(['error' => 'No book found for id ' . $id], 404);
        }

        $this->entityManager->remove($book);
        $this->entityManager->flush();

        return $this->json(['message' => 'Book deleted successfully'], 200);
    }
}