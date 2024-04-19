<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\UserType;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    private $em;

    public function __construct(
        EntityManagerInterface $em
    )
    {
        $this->em = $em;
    }


    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        $userId = $this->getUser()->getId();
        $user = $this->em->getRepository(User::class)->find($userId);

        return $this->render('profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/create', name: 'profile_create', methods: ['GET', 'POST'])]
    public function create(UserPasswordHasherInterface $passwordHasher, Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // Encript password
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);
            $user->setRoles(['ROLE_ADMIN']);

            // save user
            $this->em->persist($user);
            $this->em->flush($user);

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/create.html.twig', [
            'formCreateProfile' =>  $form
        ]);
    }

    #[Route('/profile/{id}/edit', name: 'profile_edit', methods: ['GET', 'POST'])]
    public function edit(UserPasswordHasherInterface $passwordHasher, Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // Encript password
            $hashedPassword = $passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashedPassword);

            // save user
            $this->em->persist($user);
            $this->em->flush($user);

            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/create.html.twig', [
            'formCreateProfile' =>  $form
        ]);
    }

}
