<?php

namespace App\Controller;

use App\Entity\Comments;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Books;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CommentsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/comments/book/{bookId}', name: 'get_comments_by_book', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getCommentsByBook(int $bookId): JsonResponse
    {
        $book = $this->entityManager->getRepository(Books::class)->find($bookId);
        if (!$book) {
            return $this->json(['error' => 'No book found for id ' . $bookId], 404);
        }

        $comments = $this->entityManager->getRepository(Comments::class)->findBy(['books' => $book]);

        $data = array_map(function (Comments $comment) {
            return [
                'id' => $comment->getId(),
                'comment' => $comment->getComment(),
                'date' => $comment->getDate(),
                'userId' => [
                    'id' => $comment->getUser()->getId(),
                    'username' => $comment->getUser()->getUsername(),
                ],
            ];
        }, $comments);

        return $this->json($data);
    }

    #[Route('/api/comments/book/{bookId}', name: 'add_comment', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function addComment(Request $request, int $bookId): JsonResponse
    {
        $book = $this->entityManager->getRepository(Books::class)->find($bookId);
        if (!$book) {
            return $this->json(['error' => 'No book found for id ' . $bookId], 404);
        }

        $data = json_decode($request->getContent(), true);
        if (!isset($data['comment']) || empty($data['comment'])) {
            return $this->json(['error' => 'Comment text is required'], 400);
        }

        $comment = new Comments();
        $comment->setComment($data['comment']);
        $comment->setBooks($book);
        $comment->setUser($this->getUser());
        $comment->setDate(new \DateTime());

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        return $this->json([
            'message' => 'Comment added successfully',
            'comment' => [
                'id' => $comment->getId(),
                'comment' => $comment->getComment(),
                'date' => $comment->getDate(),
            ]
        ], 201);
    }

    #[Route('/api/comments/{id}', name: 'delete_comment', methods: ['DELETE'])]
    #[IsGranted('ROLE_USER')]
    public function deleteComment(int $id): JsonResponse
    {
        $comment = $this->entityManager->getRepository(Comments::class)->find($id);
        if (!$comment) {
            return $this->json(['error' => 'No comment found for id ' . $id], 404);
        }

        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        $isOwner = $comment->getUser() && $comment->getUser()->getId() === $user->getId();

        if (!$isAdmin && !$isOwner) {
            return $this->json(['error' => 'You are not allowed to delete this comment'], 403);
        }

        $this->entityManager->remove($comment);
        $this->entityManager->flush();

        return $this->json(['message' => 'Comment deleted successfully'], 200);
    }
}