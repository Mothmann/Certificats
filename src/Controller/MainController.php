<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(): Response
    {
        $id = $this->getUser();
        $name = $this->getDoctrine()->getRepository(User::class)->name($id);
        return $this->render('main/index.html.twig', [
            'names' => $name,
        ]);
    }
}
