<?php

namespace App\Repository;

use App\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    public function fetchLatestPost()
    {
        $em = $this->getEntityManager();
        $query = $em->createQuery("SELECT p FROM App\\Entity\\POST p  ORDER BY p.id DESC");
        return $query->getResult();
    }
}
