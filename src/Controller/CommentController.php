<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\{User, Comment, Post};


class CommentController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/comments', name: 'comment_index')]
    public function index(): Response
    {
        $user = $this->getUser();

        $comments = $this->em->getRepository(Comment::class)->findAll();

        return $this->render('comment/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/comments', name: 'comment_store', methods: ['POST'])]
    public function store(Request $request): Response
    {
        $postData = $request->request->all();

        $user = $this->em->getRepository(User::class)->find(1);
        $post = $this->em->getRepository(Post::class)->find(1);

        $comment = new Comment();
        $comment->setContent("nuevo comentario");


        $this->em->persist($post);
        $this->em->flush();

        return $this->redirectToRoute('post_edit', ['id' => $post->getId()]);
    }
}
