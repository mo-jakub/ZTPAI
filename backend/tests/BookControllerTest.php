<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Entity\Books;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\ORM\EntityManagerInterface;

class BookControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();
        $this->entityManager = self::getContainer()->get(EntityManagerInterface::class);
        $this->entityManager->beginTransaction();
    }

    protected function tearDown(): void
    {
        $this->entityManager->rollback();
        parent::tearDown();
    }

    public function testGetBooks(): void
    {
        // Create test user
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setPassword('password');
        $user->setRoles(['ROLE_USER']);
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        // Authenticate
        $this->client->loginUser($user);

        // Make request
        $this->client->request('GET', '/api/books');
        
        $this->assertResponseIsSuccessful();
        $this->assertJson($this->client->getResponse()->getContent());
    }

    public function testAddBook(): void
    {
        $admin = new User();
        $admin->setEmail('admin@example.com');
        $admin->setPassword('password');
        $admin->setRoles(['ROLE_ADMIN']);
        
        $this->entityManager->persist($admin);
        $this->entityManager->flush();

        $this->client->loginUser($admin);

        $this->client->request('POST', '/api/books', [], [], [], json_encode([
            'title' => 'Test Book',
            'description' => 'Test Description',
            'cover' => 'test-cover.jpg'
        ]));

        $this->assertResponseStatusCodeSame(201);
    }

    public function testGetNonExistentBook(): void
    {
        $user = new User();
        $user->setEmail('user2@example.com');
        $user->setPassword('password');
        $user->setRoles(['ROLE_USER']);
        
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->client->loginUser($user);

        $this->client->request('GET', '/api/books/99999');
        
        $this->assertResponseStatusCodeSame(404);
    }
}