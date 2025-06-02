<?php

namespace App\Controller;

use App\Entity\Authors;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\BookAuthors;
use App\Entity\Books;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AuthorController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/authors', name: 'get_authors', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getAuthors(): JsonResponse
    {
        $authors = $this->entityManager->getRepository(Authors::class)->findAll();

        $data = array_map(function (Authors $author) {
            return [
                'id' => $author->getId(),
                'author' => $author->getAuthor(),
            ];
        }, $authors);

        return $this->json($data);
    }

    #[Route('/api/authors/{id}', name: 'get_books_by_author', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getBooksByAuthor(int $id): JsonResponse
    {
        $author = $this->entityManager->getRepository(Authors::class)->find($id);
        if (!$author) {
            return $this->json(['error' => 'No author found for id ' . $id], 404);
        }

        $bookAuthors = $this->entityManager->getRepository(BookAuthors::class)->findBy(['authors' => $author]);

        $books = [];
        foreach ($bookAuthors as $ba) {
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

        return $this->json($books);
    }

    #[Route('/api/authors', name: 'add_author', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function addAuthor(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['author']) || empty($data['author'])) {
            return $this->json(['error' => 'Author name is required'], 400);
        }

        $author = new Authors();
        $author->setAuthor($data['author']);

        $this->entityManager->persist($author);
        $this->entityManager->flush();

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
        $author = $this->entityManager->getRepository(Authors::class)->find($id);
        if (!$author) {
            return $this->json(['error' => 'No author found for id ' . $id], 404);
        }

        $this->entityManager->remove($author);
        $this->entityManager->flush();

        return $this->json(['message' => 'Author deleted successfully'], 200);
    }
}
