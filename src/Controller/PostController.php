<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     */
    public function index(BlogRepository $blogRepository): Response
    {
        // return $this->render('post/index.html.twig', [
        //     'blogs' => $blogRepository->findAll(),
        // ]);
        return $this->json($blogRepository->findAll());
    }

    /**
     * @Route("/new", name="post_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $blog = new Blog();
        // $form = $this->createForm(BlogType::class, $blog);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $entityManager = $this->getDoctrine()->getManager();
        //     $entityManager->persist($blog);
        //     $entityManager->flush();

        //     return $this->json('ok');
        //     // return $this->redirectToRoute('post_index');
        // }
        $blog->setTitle($request->request->get('title'));
        $blog->setBody($request->request->get('body'));
        // $blog->setCategories($request->request->get('categories'));
        // $blog->setAuthorFname($request->request->get('author'))
        // $data = $request->request->get('author_fname');

        return $this->json($blog);
        // return $this->render('post/new.html.twig', [
        //     'blog' => $blog,
        //     'form' => $form->createView(),
        // ]);
    }

    /**
     * @Route("/{id}", name="post_show", methods={"GET"})
     */
    public function show(Blog $blog): Response
    {
        // return $this->render('post/show.html.twig', [
        //     'blog' => $blog,
        // ]);
        return $this->json($blog);
    }

    /**
     * @Route("/{id}/edit", name="post_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Blog $blog): Response
    {
        $form = $this->createForm(BlogType::class, $blog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('post_index');
        }

        return $this->render('post/edit.html.twig', [
            'blog' => $blog,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="post_delete", methods={"POST"})
     */
    public function delete(Request $request, Blog $blog): Response
    {
        if ($this->isCsrfTokIenValid('delete'.$blog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($blog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('post_index');
    }
}
