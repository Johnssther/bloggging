<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\{User, Comment, Post};

class PostController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/posts', name: 'post_index', methods: ['GET'])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();

        $posts = $this->em->getRepository(Post::class)->findBy(
            ['user' => $user->getId()],
        );

        return $this->render('posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }


    #[Route('/posts/create', name: 'post_create', methods: ['GET'])]
    public function create(): Response
    {
        return $this->render('posts/create.html.twig');
    }

    #[Route('/posts/{id}/edit', name: 'post_edit', methods: ['GET'])]
    public function edit(Post $post): Response
    {
        return $this->render('posts/create.html.twig', ['post' => $post]);
    }

    #[Route('/posts', name: 'post_store', methods: ['POST'])]
    public function store(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $postData = $request->request->all();
        $slug = $this->generateSlug($postData['title']);

        
        $user = $this->getUser();
        $user = $this->em->getRepository(User::class)->find($user->getId());

        $post = new Post();
        $post->setTitle($postData['title']);
        $post->setDescription($postData['description']);
        $post->setUrl($postData['url']);
        $post->setSlug($slug);
        $post->setStatus($postData['status']);
        $post->setContent("");
        $post->setType('opinion');
        $post->setCreationDate(new \DateTime());
        $post->setUser($user);

        $this->em->persist($post);
        $this->em->flush();

        return $this->redirectToRoute('post_edit', ['id' => $post->getId()]);
    }

    #[Route('/posts/update/{id}', name: 'post_update', methods: ['POST'])]
    public function update(Request $request, Post $post): Response
    {
        $postData = $request->request->all();
        $slug = $this->generateSlug($postData['title']);

        $post->setTitle($postData['title']);
        $post->setDescription($postData['description']);
        $post->setUrl($postData['url']);
        $post->setSlug($slug);
        $post->setStatus($postData['status']);
        $post->setContent($postData['content']);
        $post->setType('opinion');
        $post->setCreationDate(new \DateTime());

        $this->em->persist($post);
        $this->em->flush();

        return $this->redirectToRoute('post_show', ['slug' => $post->getSlug()]);
    }

    #[Route('/posts/delete/{id}', name: 'post_delete', methods: ['POST'])]
    public function delete($id): Response
    {
        $post = $this->em->getRepository(Post::class)->find($id);
        $this->em->remove($post);
        $this->em->flush($post);

        return $this->redirectToRoute('post_index');
    }

    #[Route('/posts/{slug}', name: 'post_show', methods: ['GET'])]
    public function show($slug): Response
    {
        $post = $this->em->getRepository(Post::class)->findOneBy(['slug' => $slug]);
        $posts = $this->em->getRepository(Post::class)->findAll();

        return $this->render('posts/show.html.twig', [
            'post' => $post,
            'posts' => $posts,
        ]);
    }

    function generateSlug($text) {
        $text = strtolower($text);
        $text = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ'],
            ['a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N'],
            $text
        );
    
        $text = strtolower(preg_replace('/[^a-z0-9\s]/', '', $text));
        $slug = preg_replace('/\s+/', '-', $text);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
    
        return $slug;
    }
}
