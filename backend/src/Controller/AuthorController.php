<?php

namespace App\Controller;

use App\Entity\Authors;
use App\Service\AuthorService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AuthorController extends AbstractController
{
    private AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    #[Route('/api/authors', name: 'get_authors', methods: ['GET'])]
    public function getAuthors(): JsonResponse
    {
        $authors = $this->authorService->getAllAuthors();

        $data = array_map(function (Authors $author) {
            return [
                'id' => $author->getId(),
                'author' => $author->getAuthor(),
            ];
        }, $authors);

        return $this->json($data);
    }

    #[Route('/api/authors/{id}', name: 'get_books_by_author', methods: ['GET'])]
    public function getBooksByAuthor(int $id): JsonResponse
    {
        $author = $this->authorService->getAuthorById($id);
        if (!$author) {
            return $this->json(['error' => 'No author found for id ' . $id], 404);
        }

        $books = $this->authorService->getBooksByAuthor($author);

        $data = array_map(function ($book) {
            return [
                'id' => $book->getId(),
                'title' => $book->getTitle(),
                'description' => $book->getDescription(),
                'cover' => $book->getCover(),
            ];
        }, $books);

        return $this->json($data);
    }

    #[Route('/api/authors', name: 'add_author', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function addAuthor(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['author']) || empty($data['author'])) {
            return $this->json(['error' => 'Author name is required'], 400);
        }

        $author = $this->authorService->addAuthor($data['author']);

        return $this->json([
            'message' => 'Author added successfully',
            'author' => [
                'id' => $author->getId(),
                'author' => $author->getAuthor(),
            ]
        ], 201);
    }

    #[Route('/api/authors/{id}', name: 'delete_author', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteAuthor(int $id): JsonResponse
    {
        $author = $this->authorService->getAuthorById($id);
        if (!$author) {
            return $this->json(['error' => 'No author found for id ' . $id], 404);
        }

        $this->authorService->deleteAuthor($author);

        return $this->json(['message' => 'Author deleted successfully'], 200);
    }
}