<?php

namespace App\Repository;

use App\Entity\BookAuthors;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookAuthors>
 */
class BookAuthorsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookAuthors::class);
    }

    // Additional custom methods for managing BookAuthors entities can be added here
}