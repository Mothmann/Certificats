<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $admin = $this->getDoctrine()->getRepository(User::class)->find($id);
        $check = $admin->getRoles();
        if ($check == ["ROLE_ADMIN","ROLE_USER"]){
           return($this->redirectToRoute('admin_home'));
        }
        else {
            return $this->render('main/index.html.twig', [
            'names' => $name,
        ]);
        }

    }
    /**
     * @Route("/admin", name="admin_home")
     */
    public function admin(): Response{
        $id = $this->getUser();
        $name = $this->getDoctrine()->getRepository(User::class)->name($id);
        $admin = $this->getDoctrine()->getRepository(User::class)->find($id);
        $check = $admin->getRoles();
        return $this->render('main/index.html.twig', [
            'names' => $name,
        ]);
    }
}
