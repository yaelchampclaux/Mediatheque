<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PolitiqueController extends AbstractController
{
    #[Route("/politique",name: 'politique', methods: ['GET'])]
    public function politique(): Response
    {
        return $this->render('Accueil/Politique.html.twig');
    }
}