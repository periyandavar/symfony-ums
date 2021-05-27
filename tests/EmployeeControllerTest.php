<?php

namespace App\Test;

use App\Controller\EmployeeController;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;
use PHPUnit\Framework\TestCase;

class EmployeeControllerTest extends TestCase
{
    public function testTopSalary()
    {
        $employee = new Employee();
        $employee->setName("Raja");
        $employee->setSalary(2000);
        $empRepo = $this->createMock(EmployeeRepository::class);
        $empRepo->expects($this->once())
            ->method('findTopSalary')
            ->willReturn($employee);

        $objectManager = $this->createMock(ObjectManager::class);
        $objectManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($empRepo);
        
        $topSalary = (new EmployeeController($objectManager))->fetchTopSalary();
        $this->assertEquals($employee->getName(), $topSalary->getContent());
        // $this->assertEquals("Ram", $topSalary->getContent());
    }
}
