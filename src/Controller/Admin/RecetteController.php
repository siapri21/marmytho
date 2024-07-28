<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/recette', name: 'admin_recette_')]
class RecetteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(RecetteRepository $repository): Response
    {
        $recipes = $repository->findAll();

        return $this->render('admin/recette/index.html.twig', ['recipes' => $recipes]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $recipe = new Recette();
        $form = $this->createForm(RecetteType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageFile')->getData();

            if ($file) {
                $filedir = $this->getParameter('kernel.project_dir') . '/public/img/imageFile';
                if (!file_exists($filedir)) {
                    mkdir($filedir, 0777, true);
                }
                $fileName = $recipe->getSlug() . '.' . $file->getClientOriginalExtension();
                $file->move($filedir, $fileName);
                $recipe->setFileName($fileName);
            }

            $em->persist($recipe);
            $em->flush();

            $this->addFlash('success', 'Recette créée !');

            return $this->redirectToRoute('admin_recette_index');
        }

        return $this->render('admin/recette/new.html.twig', ['recipeForm' => $form->createView()]);
    }

    #[Route('/detail/{slug}', name: 'show')]
    public function show(Recette $recipe): Response
    {
        return $this->render('admin/recette/show.html.twig', ['recipe' => $recipe]);
    }

    #[Route('/edit/{slug}', name: 'edit', methods: ['GET', 'POST'])]
    public function update(Request $request, Recette $recipe, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RecetteType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageFile')->getData();

            if ($file) {
                $filedir = $this->getParameter('kernel.project_dir') . '/public/img/imageFile';
                if (!file_exists($filedir)) {
                    mkdir($filedir, 0777, true);
                }
                $fileName = $recipe->getSlug() . '.' . $file->getClientOriginalExtension();
                $file->move($filedir, $fileName);
                $recipe->setFileName($fileName);
            }

            $em->flush();

            $this->addFlash('success', 'Recette modifiée !');

            return $this->redirectToRoute('admin_recette_index');
        }

        return $this->render('admin/recette/edit.html.twig', ['recipeForm' => $form->createView()]);
    }

    #[Route('/delete/{slug}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Recette $recipe, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete' . $recipe->getId(), $request->request->get('_token'))) {
            $em->remove($recipe);
            $em->flush();

            $this->addFlash('success', 'Recette supprimée !');
        }

        return $this->redirectToRoute('admin_recette_index');
    }
}