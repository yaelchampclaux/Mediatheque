<?php

namespace App\Controller;

use App\Entity\TypeOeuvre;
use App\Form\TypeOeuvreType;
use App\Repository\TypeOeuvreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/type/oeuvre')]
final class TypeOeuvreController extends AbstractController
{
    #[Route(name: 'app_type_oeuvre_index', methods: ['GET'])]
    public function index(TypeOeuvreRepository $typeOeuvreRepository): Response
    {
        return $this->render('type_oeuvre/index.html.twig', [
            'type_oeuvres' => $typeOeuvreRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_type_oeuvre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $typeOeuvre = new TypeOeuvre();
        $form = $this->createForm(TypeOeuvreType::class, $typeOeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typeOeuvre);
            $entityManager->flush();

            return $this->redirectToRoute('app_type_oeuvre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_oeuvre/new.html.twig', [
            'type_oeuvre' => $typeOeuvre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_oeuvre_show', methods: ['GET'])]
    public function show(TypeOeuvre $typeOeuvre): Response
    {
        return $this->render('type_oeuvre/show.html.twig', [
            'type_oeuvre' => $typeOeuvre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_type_oeuvre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TypeOeuvre $typeOeuvre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TypeOeuvreType::class, $typeOeuvre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_type_oeuvre_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('type_oeuvre/edit.html.twig', [
            'type_oeuvre' => $typeOeuvre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_type_oeuvre_delete', methods: ['POST'])]
    public function delete(Request $request, TypeOeuvre $typeOeuvre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeOeuvre->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($typeOeuvre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_type_oeuvre_index', [], Response::HTTP_SEE_OTHER);
    }
}
