<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryType;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
 
class CategoryController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/categories', name: 'category_index', options: ["expose" => true]) ]
    public function index(Request $request): Response
    {
        $categories = $this->em->getRepository(Category::class)->findAll();

        if($request->isXmlHttpRequest()) {
            $categories = $this->em->getRepository(Category::class)->findAll();
            return new JsonResponse(['data' => [], 'success' => true]);
        }

        return $this->render('categories/index.html.twig', [
            'categories' => $categories,
        ]);
    }

   #[Route('/categories/create', name: 'category_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            // save category
            $this->em->persist($category);
            $this->em->flush($category);

            $this->addFlash('success', 'La categoria se guardo correctamente!');
            return $this->redirectToRoute('category_index');
        }

        return $this->render('categories/create.html.twig', [
            'formCreateCategory' =>  $form
        ]);
    }

    #[Route('/categories/{id}/edit', name: 'category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Category $category): Response
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            // edit category
            $this->em->persist($category);
            $this->em->flush($category);

            return $this->redirectToRoute('category_index');
        }

        return $this->render('categories/create.html.twig', [
            'formCreateCategory' =>  $form
        ]);
    }


    #[Route('/categories/delete/{id}', name: 'category_delete', methods: ['POST'])]
    public function delete($id): Response
    {
        $post = $this->em->getRepository(Category::class)->find($id);
        $this->em->remove($post);
        $this->em->flush($post);

        return $this->redirectToRoute('category_index');
    }
}
