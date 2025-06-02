<?php

namespace App\Controller;

use App\Entity\Genres;
use App\Entity\BookGenres;
use App\Entity\Books;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class GenreController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/genres', name: 'get_genres', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getGenres(): JsonResponse
    {
        $genres = $this->entityManager->getRepository(Genres::class)->findAll();

        $data = array_map(function (Genres $genre) {
            return [
                'id' => $genre->getId(),
                'genre' => $genre->getGenre(),
            ];
        }, $genres);

        return $this->json($data);
    }

    #[Route('/api/genres/{id}', name: 'get_books_by_genre', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getBooksByGenre(int $id): JsonResponse
    {
        $genre = $this->entityManager->getRepository(Genres::class)->find($id);
        if (!$genre) {
            return $this->json(['error' => 'No genre found for id ' . $id], 404);
        }

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

        return $this->json($books);
    }

    #[Route('/api/genres', name: 'add_genre', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function addGenre(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['genre']) || empty($data['genre'])) {
            return $this->json(['error' => 'Genre name is required'], 400);
        }

        $genre = new Genres();
        $genre->setGenre($data['genre']);

        $this->entityManager->persist($genre);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Genre added successfully',
            'genre' => [
                'id' => $genre->getId(),
                'genre' => $genre->getGenre(),
            ]
        ], 201);
    }

    #[Route('/api/genres/{id}', name: 'delete_genre', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteGenre(int $id): JsonResponse
    {
        $genre = $this->entityManager->getRepository(Genres::class)->find($id);
        if (!$genre) {
            return $this->json(['error' => 'No genre found for id ' . $id], 404);
        }

        $this->entityManager->remove($genre);
        $this->entityManager->flush();

        return $this->json(['message' => 'Genre deleted successfully'], 200);
    }
}