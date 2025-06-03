<?php

namespace App\Controller;

use App\Entity\Genres;
use App\Service\GenreService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class GenreController extends AbstractController
{
    private GenreService $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    #[Route('/api/genres', name: 'get_genres', methods: ['GET'])]
    public function getGenres(): JsonResponse
    {
        $genres = $this->genreService->getAllGenres();

        $data = array_map(function (Genres $genre) {
            return [
                'id' => $genre->getId(),
                'genre' => $genre->getGenre(),
            ];
        }, $genres);

        return $this->json($data);
    }

    #[Route('/api/genres/{id}', name: 'get_books_by_genre', methods: ['GET'])]
    public function getBooksByGenre(int $id): JsonResponse
    {
        $genre = $this->genreService->getGenreById($id);
        if (!$genre) {
            return $this->json(['error' => 'No genre found for id ' . $id], 404);
        }

        $books = $this->genreService->getBooksByGenre($genre);

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

        $genre = $this->genreService->addGenre($data['genre']);

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
        $genre = $this->genreService->getGenreById($id);
        if (!$genre) {
            return $this->json(['error' => 'No genre found for id ' . $id], 404);
        }

        $this->genreService->deleteGenre($genre);

        return $this->json(['message' => 'Genre deleted successfully'], 200);
    }
}