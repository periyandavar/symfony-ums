<?php

namespace App\Test;

use App\Entity\Employee;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EmployeeRepositoryTest extends KernelTestCase
{
    private $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    }

    public function testFindTopSalary()
    {
        $result = $this->entityManager->getRepository(Employee::class)->findTopSalary();
        $this->assertSame("as", $result->getName());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null;
    }
}
