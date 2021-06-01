<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class UserController extends AbstractController
{
    /**
     * @Route("/home",name="app_home_page")
     */
    public function home()
    {
        $user = ($user = $this->getUser()) and ($user->getEmail());
        return $this->render("user/home.html.twig", ["user" => $user]);
    }

    /**
     * @Route("/my-role", name="user_role")
     * @IsGranted("ROLE_USER")
     */
    public function myRole()
    {
        // $this->denyAccessUnlessGranted("ROLE_USER");
        $role = $this->getUser()->getRoles();
        return $this->render("user/myrole.html.twig", ["roles" => $role]);
    }
}

