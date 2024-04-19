<?php

namespace App\Controller\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EntryController extends AbstractController
{
    #[Route('/blog/entry', name: 'app_blog_entry')]
    public function index(): Response
    {
        return $this->render('blog/entry/index.html.twig', [
            'controller_name' => 'EntryController',
        ]);
    }
}
