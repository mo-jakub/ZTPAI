<?php

namespace App\Controller;

use App\Entity\Tags;
use App\Service\TagService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class TagController extends AbstractController
{
    private TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    #[Route('/api/tags', name: 'get_tags', methods: ['GET'])]
    public function getTags(): JsonResponse
    {
        $tags = $this->tagService->getAllTags();

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
        $tag = $this->tagService->getTagById($id);
        if (!$tag) {
            return $this->json(['error' => 'No tag found for id ' . $id], 404);
        }

        $books = $this->tagService->getBooksByTag($tag);

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

        $tag = $this->tagService->addTag($data['tag']);

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
        $tag = $this->tagService->getTagById($id);
        if (!$tag) {
            return $this->json(['error' => 'No tag found for id ' . $id], 404);
        }

        $this->tagService->deleteTag($tag);

        return $this->json(['message' => 'Tag deleted successfully'], 200);
    }
}