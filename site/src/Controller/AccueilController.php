<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route(name: 'accueil', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('Accueil/index.html.twig');
    }

    #[Route('/qui-sommes-nous', name: 'qui_sommes_nous', methods: ['GET'])]
    public function quiSommesNous(): Response
    {
        return $this->render('Accueil/qui_sommes_nous.html.twig');
    }

}