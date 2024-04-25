<?php

namespace App\Controller\Panel\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ConfigurationController extends AbstractController
{
    #[Route('/panel/admin/configuration', name: 'app_panel_admin_configuration')]
    public function index(): Response
    {
        return $this->render('panel/admin/configuration/index.html.twig', [
            'controller_name' => 'ConfigurationController',
        ]);
    }
}
