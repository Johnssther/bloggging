<?php

namespace App\Controller\Panel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostsController extends AbstractController
{
    #[Route('/panel/posts', name: 'app_panel_posts')]
    public function index(): Response
    {
        return $this->render('panel/posts/index.html.twig', [
            'controller_name' => 'PostsController',
        ]);
    }
}
