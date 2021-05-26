<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * Lists all Posts.
     *
     * @Route("/show", name="show_blogs")
     */
    public function list(): Response
    {
        $posts = $this->getDoctrine()
            ->getRepository(Post::class)
            ->findAll();

        return $this->render('blog/list.html.twig', ['posts' => $posts]);
    }

    /**
     * Displays the contents of the post.
     *
     * @Route("/show/{id<\d+>}", name="show_blog")
     */
    public function show(int $id): Response
    {
        $post = $this->getDoctrine()
            ->getRepository(Post::class)
            ->find($id);
        if (!$post) {
            throw $this->createNotFoundException();
        }

        return $this->render('blog/show.html.twig', ['post' => $post]);
    }

    /**
     * Lists all latest Posts.
     *
     * @Route("/latest", name="show_latest_blogs")
     */
    public function latest()
    {
        $posts = $this->getDoctrine()->getRepository(Post::class)->fetchLatestPost();
        return $this->render('blog/list.html.twig', ['posts' => $posts]);
    }
}
