<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Post;
use App\Entity\User;

class HomeController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/home', name: 'app_home')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        $posts = $this->em->getRepository(Post::class)->findBy(
            ['user' => $user->getId()],
        );

        $publishedCount = 0;
        $draftCount = 0;
        $scheduledCount = 0;
        $lockedCount = 0;
        $archivedCount = 0;
        $hiddenCount = 0;
        foreach ($posts as $post) {
            switch ($post->getStatus()) {
                case 'published':
                    $publishedCount++;
                    break;
                case 'draft':
                    $draftCount++;
                    break;
                case 'scheduled':
                    $scheduledCount++;
                    break;
                case 'locked':
                    $lockedCount++;
                    break;
                case 'archived':
                    $archivedCount++;
                    break;
                case 'hidden':
                    $hiddenCount++;
                    break;
                
            }
        }

        $stadistics = [
            'published' => $publishedCount,
            'draft' => $draftCount,
            'scheduled' => $scheduledCount,
            'locked' => $lockedCount,
            'archived' => $archivedCount,
            'hidden' => $hiddenCount,
        ];

        return $this->render('home/index.html.twig', [
            'stadistics' => $stadistics,
        ]);
    }
}
