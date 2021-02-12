<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiliereController extends AbstractController
{
    /**
     * @Route("/filiere", name="filiere")
     */
    public function index(): Response
    {
        return $this->render('filiere/index.html.twig', [
            'controller_name' => 'FiliereController',
        ]);
    }
}
