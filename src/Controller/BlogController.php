<?php

namespace App\Controller;

use App\Entity\Post;
use App\Serializer\PostNormalizer;
use App\Serializer\PostSerializer;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Serializer\YamlEncoder;

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
     * Sends the encoded formt of posts
     *
     * @Route("/encode", name="yaml_encoder")
     * @param YamlEncoder $yamlEncoder
     * @return Response
     */
    public function encode(YamlEncoder $yamlEncoder, PostNormalizer $postNormalizer, PostSerializer $serializer): Response
    {
        $post = $this->getDoctrine()->getManager()->getRepository(Post::class)
            ->findAll()[0];
        // dump($post);
        // $yaml = $postNormalizer->normalize($post, Post::class);
        // dump($yaml);
        // $yaml = $yamlEncoder->encode($yaml, 'yaml');
        // dump($yaml);
        $yaml = $serializer->serialize($post);
        // return $this->render('blog/list.html.twig', ['posts' => $posts]);
        return new Response("<html><body><pre>"  . $yaml . "</pre></html></body>");
    }

    /**
     * Decodes the data
     *
     * @Route("/decode", name="yaml_deocoder")
     *
     * @param YamlEncoder $yamlEncoder
     * @return Response
     */
    public function decode(YamlEncoder $yamlEncoder, PostNormalizer $postNormalizer, PostSerializer $serializer): Response
    {
        $data = <<<EOT
        id: 1
        title: Bird
        body: This is a bird
        EOT;
        // $yaml = $yamlEncoder->decode($data, 'yaml');
        // dump($yaml);
        // $yaml = $postNormalizer->denormalize($yaml, Post::class);
        $yaml = $serializer->deserialize($data, Post::class, 'yaml');
        dump($yaml);
        return new Response("<html><body> </html></body>");
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

    /**
     * @Route("/recent", name = "recent_article")
     */
    public function recent()
    {
        $posts = [1, 2, 4];
        return $this->render("blog/recent.html.twig", ['posts' => $posts]);
    }

    /**
     * @Route("/posts/all", name="all_posts")
     */
    public function AllPosts(Connection $connection)
    {
        $posts = $connection->fetchAll('Select title from post');
        return $this->json($posts);
    }
}
