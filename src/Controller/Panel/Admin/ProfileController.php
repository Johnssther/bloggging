<?php

namespace App\Controller\Panel\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/panel/admin/profile', name: 'app_panel_admin_profile')]
    public function index(): Response
    {
        return $this->render('panel/admin/profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
