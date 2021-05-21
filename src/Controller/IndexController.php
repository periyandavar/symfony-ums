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
        $url = $this->generateUrl('home_page', ['user' => 'raja']);
        $msg = "welcome <br> go to <a href='" . $url . "'>home</a>";
        return new Response($msg);
    }

    public function yml(Request $request): Response
    {
        return new Response('yml');
    }

    /**
     * @Route("/doc/{param}", methods={"GET", "POST"}, priority=2, requirements={"param"=".+"})
     */
    public function paramName(?string $param = null)
    {
        return new Response("Param $param is caught by paramName..!");
    }

    /**
     * @Route("/doc/{param<\d+>?}", methods={"GET", "POST"}, priority=3)
     */
    public function param(Request $request)
    {
        $atr = $request->attributes->get('param');
        return new Response("Param caught..!<br> $atr");
    }


    /**
     * @Route("/home", methods={"GET", "POST"}, name="home_page")//support only double quotes
     * [Route('/home', methods:['GET', 'POST'])]
     */
    public function home(Request $request): Response
    {
        $msg = "Welcome to home " . $request->query->get('user');
        return new Response($msg);
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

    public function xml(Request $request)
    {
        return new Response("xml");
    }

    public function php(Request $request)
    {
        return new Response('php');
    }
}
