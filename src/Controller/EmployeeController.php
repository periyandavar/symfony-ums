<?php

namespace App\Controller;

use App\Entity\Employee;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{

    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @Route("/emp/add", name = "add_empl", methods={"GET"})
     */
    public function add()
    {
        return $this->render('employee/add.html.twig');
    }

    /**
     * @Route("/emp/top")
     */
    public function fetchTopSalary()
    {
        $employee = $this->objectManager->getRepository(Employee::class)->findTopSalary();

        return new Response($employee->getName());
    }

    /**
     * @Route("/emp/add", name="insert-record", methods={"POST"})
     */
    public function insert(Request $request)
    {
        $name = $request->request->get('name');
        $salary = $request->request->get('salary');
        $file = $request->files->get('pdf');
        $employee = new Employee();
        $employee->setName($name);
        $employee->setSalary($salary);
        $employee->setFile($file);
        $employee->upload($this->getParameter('upload-dir'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($employee);
        try {
            $em->flush();
        } catch (ORMException $e) {
            return $this->render('employee/add.html.twig', ['msg' => 'Unable to add..']);
        }

        return $this->render('employee/add.html.twig', ['msg' => 'Success..']);
    }

    /**
     * @Route("/emp/{id}", name="view_employee")
     */
    public function view(Employee $employee)
    {
        return $this->json($employee);
    }
}
