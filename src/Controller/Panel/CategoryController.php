<?php

namespace App\Controller\Panel;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CategoryController extends AbstractController
{
    #[Route('/panel/category', name: 'app_panel_category')]
    public function index(): Response
    {
        return $this->render('panel/category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }
}
