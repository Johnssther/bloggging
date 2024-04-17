<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CategoryType;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
 
class CategoryController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/categories', name: 'category_index')]
    public function index(): Response
    {
        $categories = $this->em->getRepository(Category::class)->findAll();

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
