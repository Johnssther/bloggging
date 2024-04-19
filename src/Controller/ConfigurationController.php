<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ConfigurationType;
use App\Entity\Configuration;

class ConfigurationController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/configurations', name: 'app_configuration')]
    public function index(): Response
    {
        return $this->render('configurations/index.html.twig', [
            'controller_name' => 'ConfigurationController',
        ]);
    }

    #[Route('/configurations/create', name: 'configuration_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $configuration = new Configuration();
        $form = $this->createForm(ConfigurationType::class, $configuration);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $configuration = $form->getData();

            // save configuration
            $this->em->persist($configuration);
            $this->em->flush($configuration);

            // return $this->redirectToRoute('app_profile');
        }

        return $this->render('configurations/index.html.twig', [
            'formCreateConfiguration' => $form,
        ]);
    }
}
