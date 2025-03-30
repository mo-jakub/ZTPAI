<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    private array $users = [
        ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com'],
        ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com'],
    ];

    #[Route('/api/users', name: 'get_users', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
        return $this->json($this->users);
    }

    #[Route('/api/users/{id}', name: 'get_user_by_id', methods: ['GET'])]
    public function getUserById(int $id): JsonResponse
    {
        $user = $this->findUserById($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        return $this->json($user);
    }

    #[Route('/api/users', name: 'add_user', methods: ['POST'])]
    public function addUser(): JsonResponse
    {
        $newUser = [
            'id' => count($this->users) + 1,
            'name' => 'New User',
            'email' => 'newuser@example.com',
        ];

        $this->users[] = $newUser;

        return $this->json(['message' => 'User added successfully', 'user' => $newUser], 201);
    }

    #[Route('/api/users/{id}', name: 'delete_user_by_id', methods: ['DELETE'])]
    public function deleteUserById(int $id): JsonResponse
    {
        $user = $this->findUserById($id);
        if (!$user) {
            return $this->json(['error' => 'User not found'], 404);
        }

        $this->users = array_filter($this->users, fn($u) => $u['id'] !== $id);
        $this->users = array_values($this->users);

        return $this->json(['message' => 'User deleted successfully']);
    }

    private function findUserById(int $id): ?array
    {
        foreach ($this->users as $user) {
            if ($user['id'] === $id) {
                return $user;
            }
        }
        return null;
    }
}