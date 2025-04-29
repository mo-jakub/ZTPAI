<?php

namespace App\Repository;

use App\Entity\BookTags;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BookTags>
 */
class BookTagsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BookTags::class);
    }

    // Additional custom methods for managing BookTags entities can be added here
}