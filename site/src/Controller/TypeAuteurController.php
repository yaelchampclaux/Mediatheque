<?php

namespace App\Controller;

use App\Entity\TypeAuteur;
use App\Form\TypeAuteurType;
use App\Repository\TypeAuteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/type/auteur')]
final class TypeAuteurController extends AbstractController
{
    #[Route(name: 'app_type_auteur_index', methods: ['GET'])]
    public function index(TypeAuteurRepository $typeAuteurRepository): Response
    {
        return $this->render('type_auteur/index.html.twig', [
            'type_auteurs' => $typeAuteurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_auteur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeAuteur = new TypeAuteur();
        $form = $this->createForm(TypeAuteurType::class, $typeAuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeAuteur);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_auteur/new.html.twig', [
            'type_auteur' => $typeAuteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_auteur_show', methods: ['GET'])]
    public function show(TypeAuteur $typeAuteur): Response
    {
        return $this->render('type_auteur/show.html.twig', [
            'type_auteur' => $typeAuteur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_auteur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeAuteur $typeAuteur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeAuteurType::class, $typeAuteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_auteur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_auteur/edit.html.twig', [
            'type_auteur' => $typeAuteur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_auteur_delete', methods: ['POST'])]
    public function delete(Request $request, TypeAuteur $typeAuteur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeAuteur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($typeAuteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_auteur_index', [], Response::HTTP_SEE_OTHER);
    }
}
