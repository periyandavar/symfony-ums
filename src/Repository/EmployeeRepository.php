<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    public function findTopSalary()
    {
        $em = $this->getEntityManager();
        $query = $em->createQueryBuilder();
        $query->select('e')
            ->from(Employee::class, 'e')
            ->orderBy('e.salary', 'DESC')
            ->setMaxResults(1);
        return $query->getQuery()->getResult()[0];
    }
}

