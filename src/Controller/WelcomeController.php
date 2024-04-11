<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\{User, Comment, Post};
use App\Form\CommentType;

class WelcomeController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/welcome', name: 'app_welcome')]
    public function index(): Response
    {
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }

    #[Route('/', name: 'welcome_post_published', methods: ['GET'])]
    public function published(): Response
    {
        $posts = $this->em->getRepository(Post::class)->findBy(
            ['status' => 'published'],
            ['creation_date' => 'ASC']
        );

        $currentTime = new \DateTime();
        foreach ($posts as $post) {
            $creationDate = $post->getCreationDate();
            $diferenciaHoras = $currentTime->diff($creationDate)->h;
            $post->diferenciaHoras = $diferenciaHoras;
        }

        return $this->render('welcome/published.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/blog/{slug}', name: 'blog_show', methods: ['GET', 'POST'])]
    public function show($slug, Request $request): Response
    {
        $post = $this->em->getRepository(Post::class)->findOneBy(['slug' => $slug]);
        $posts = $this->em->getRepository(Post::class)->findBy(['status' => 'published']);

        // form comment
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // Get IP client
            $clientIp = $request->getClientIp();

            $comment = $form->getData();
            $comment->setStatus('created');
            $comment->setStatus('created');
            $comment->setUpvotes(0);
            $comment->setDownvotes(0);
            $comment->setUserIp($clientIp);
            $comment->setPost($post);

            // save comment
            $this->em->persist($comment);
            $this->em->flush($comment);

            return $this->redirectToRoute('welcome_post_published');
        }

        return $this->render('welcome/show.html.twig', [
            'post' => $post,
            'posts' => $posts,
            'formComment' => $form,
            'comments' => $post->getComments(),
        ]);
    }
}
