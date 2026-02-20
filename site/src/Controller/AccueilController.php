<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'accueil', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Accueil/index.html.twig');
    }

    #[Route('/politique-confidentialite', name: 'politique_confidentialite', methods: ['GET'])]
    public function politiqueConfidentialite(): Response
    {
        return $this->render('Accueil/politique_confidentialite.html.twig');
    }

}