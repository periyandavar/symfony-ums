<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    public function welcome(): Response
    {
        return new Response('welcome');
    }

    /**
     * @Route("/home")
     */
    public function home(): Response
    {
        return new Response('home');
    }

    /**
     * @Route("/temp")
     */
    public function temp(): Response
    {
        return $this->render('index/temp.html.twig', ["str" => 'template']);
    }

    /**
     * @Route("/sam",name="sam")
     */
    public function sam()
    {
        return $this->render('index/temp.html.twig', ["str" => 'sample']);
    }

    /**
     * @Route("/user/{user?}",name="user-name")
     */
    public function user(Request $request)
    {
        $res = dump($request);
        $user = $request->get('user');
        return new Response("welcome " . $user);
    }
}
