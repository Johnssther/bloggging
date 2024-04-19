<?php

namespace App\Controller\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostController extends AbstractController
{
    #[Route('/blog/post', name: 'app_blog_post')]
    public function index(): Response
    {
        return $this->render('blog/post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
}
