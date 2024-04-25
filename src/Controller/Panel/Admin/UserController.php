<?php

namespace App\Controller\Panel\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    #[Route('/panel/admin/user', name: 'app_panel_admin_user')]
    public function index(): Response
    {
        return $this->render('panel/admin/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
