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

    #[Route('/qui-sommes-nous', name: 'app_qui_sommes_nous')]
    public function quiSommesNous(): Response
    {
  
    $listaDesarrolladores = [
        ['nombre' => 'Juan', 'apellido' => 'Pérez'],
        ['nombre' => 'Halima', 'apellido' => 'Bentaj'],
        ['nombre' => 'Salomé', 'apellido' => 'Fuenmayor'],
    ];
    return $this->render('Accueil/qui_sommes_nous.html.twig', [
        // 'nombre_en_twig' => $variable_en_php
        'desarrolladores' => $listaDesarrolladores 
    ]);
    }
}

