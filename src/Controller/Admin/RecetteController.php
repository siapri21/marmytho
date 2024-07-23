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


#[Route('/admin/recette' , 'admin_recette_')]
class RecetteController extends AbstractController
{
    #[Route('/', name: 'index' , methods: ['GET'])]
    public function index(RecetteRepository $recette): Response
    {
        return $this->render('admin/recette/index.html.twig', [
            'controller_name' => 'RecetteController', 'recette'=> $recette->findAll()
        ]);
    }

    #[Route('/new' , name: 'new', methods: ['GET','POST'])]
    public function new(Request $request , EntityManagerInterface $entityManager) : Response
    {
        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){

            $entityManager->persist($recette);
            $entityManager->flush();

            $this->addFlash('success', 'La recette a bien été ajoutée');

            return $this->redirectToRoute('admin_recette_index');
        }
        return $this->render('admin/recette/new.html.twig' ,['recette' =>$recette ,'form' => $form]);
    }


    #[Route('/edit/{id}' , name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager, Recette $recette) : Response
    {
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            $this->addFlash('success', 'La recette a bien été modifiée');

            return $this->redirectToRoute('admin_recette_index');

        }
        return $this->render('admin/recette/edit.html.twig', ['form'=>$form]);
    }


    #[Route('/show/{id}' , name: 'show', methods: ['GET, POST'])]
    public function show() : Response
    {
        return $this->render('admin/recette/show.html.twig');
    }

    
}
