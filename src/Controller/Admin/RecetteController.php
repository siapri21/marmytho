<?php

namespace App\Controller\Admin;

use App\Entity\Recette;
use App\Form\RecetteType;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;



#[Route('/admin/recette', name: 'admin_recette_')]
class RecetteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(RecetteRepository $repository): Response
    {
        $recipe = $repository->findAll();

        return $this->render('admin/recette/index.html.twig', ['recipes' => $recipe]);
    }

    #[Route('/new', name: 'new', methods:['post','get'])]
    public function new(Request $request, EntityManagerInterface $em)
    {
        $recipe = new Recette();
        $form = $this->createForm(RecetteType::class, $recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageFile')->getData();

            if ($file) {
                $filedir = $this->getParameter('kernel.project_dir') . '/public/img/imageFile';
                $fileName = $recipe->getSlug() . '.' . $file->getClientOriginalExtension();
                $file->move($filedir, $fileName);
                $recipe->setFileName($fileName);
            }


            $em->persist($recipe);
            $em->flush();

            $this->addFlash('success', 'Recette créé !');

            return $this->redirectToRoute('admin_recette_index');
        }

        return $this->render('admin/recette/new.html.twig',['recipeForm'=>$form]);
    }

    #[Route('/detail/{slug}', name: 'show')]
    public function show(Recette $recipe)
    { //paramConverters

        return $this->render('admin/recette/show.html.twig', ['recipe' => $recipe]);
    }

    #[Route('/edit{slug}', name: 'edit')]
    public function update(Request $request, Recette $recipe, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(RecetteType::class, $recipe);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $this->addFlash('success', 'Recette modifié !');

            return $this->redirectToRoute('admin_recette_index');
        }

        return $this->render('admin/recette/edit.html.twig', ['recipeForm' => $form]);
    }

    #[Route('/delete/{slug}', name:'delete', methods:'DELETE')]
    public function delete(Recette $recipe, EntityManagerInterface $em)
    {
        $em->remove($recipe);
        $em->flush();

        $this->addFlash('success', 'Recette supprimé !');

        return $this->redirectToRoute('admin_recette_index');
    }

}