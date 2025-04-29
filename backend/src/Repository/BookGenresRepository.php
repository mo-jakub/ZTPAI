<?php

namespace App\Repository;

use App\Entity\BookGenres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookGenres>
 */
class BookGenresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookGenres::class);
    }

    // Additional custom methods for managing BookGenres entities can be added here
}