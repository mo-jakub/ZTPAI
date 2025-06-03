<?php

namespace App\Controller;

use App\Entity\Tags;
use App\Entity\BookTags;
use App\Entity\Books;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class TagController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/tags', name: 'get_tags', methods: ['GET'])]
    public function getTags(): JsonResponse
    {
        $tags = $this->entityManager->getRepository(Tags::class)->findAll();

        $data = array_map(function (Tags $tag) {
            return [
                'id' => $tag->getId(),
                'tag' => $tag->getTag(),
            ];
        }, $tags);

        return $this->json($data);
    }

    #[Route('/api/tags/{id}', name: 'get_books_by_tag', methods: ['GET'])]
    public function getBooksByTag(int $id): JsonResponse
    {
        $tag = $this->entityManager->getRepository(Tags::class)->find($id);
        if (!$tag) {
            return $this->json(['error' => 'No tag found for id ' . $id], 404);
        }

        $bookTags = $this->entityManager->getRepository(BookTags::class)->findBy(['tags' => $tag]);

        $books = [];
        foreach ($bookTags as $ba) {
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

    #[Route('/api/tags', name: 'add_tag', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function addTag(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['tag']) || empty($data['tag'])) {
            return $this->json(['error' => 'Tag name is required'], 400);
        }

        $tag = new Tags();
        $tag->setTag($data['tag']);

        $this->entityManager->persist($tag);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Tag added successfully',
            'tag' => [
                'id' => $tag->getId(),
                'tag' => $tag->getTag(),
            ]
        ], 201);
    }

    #[Route('/api/tags/{id}', name: 'delete_tag', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteTag(int $id): JsonResponse
    {
        $tag = $this->entityManager->getRepository(Tags::class)->find($id);
        if (!$tag) {
            return $this->json(['error' => 'No tag found for id ' . $id], 404);
        }

        $bookTags = $this->entityManager->getRepository(\App\Entity\BookTags::class)->findBy(['tags' => $tag]);
        foreach ($bookTags as $bt) {
            $this->entityManager->remove($bt);
        }

        $this->entityManager->remove($tag);
        $this->entityManager->flush();

        return $this->json(['message' => 'Tag deleted successfully'], 200);
    }
}