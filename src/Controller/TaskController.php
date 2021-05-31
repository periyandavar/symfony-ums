<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\Type\TaskType;
use DateTime;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends AbstractController
{
    /**
     * @Route("/task/new", name="new_task")
     */
    public function new(Request $request): Response
    {
        $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new DateTime('tomorrow'));

        // $form = $this->createFormBuilder($task)
        //     ->add('task', TextType::class)
        //     ->add('dueDate', DateType::class)
        //     ->add('save', SubmitType::class, ['label' => 'create Task'])
        //     ->getForm();

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
            return $this->redirect('/success');
        }
        return $this->render('task/new.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/success", name="task_success")
     */
    public function success()
    {
        return new Response("Success..!");
    }
}
