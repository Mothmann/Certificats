<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categories;
use App\Form\CategoriesType;

class FormController extends AbstractController
{
    /**
     * @Route("/admin/form", name="form")
     */
    public function index(): Response
    {
        return $this->render('form/index.html.twig', [
            'controller_name' => 'FormController',
        ]);
    }
    /**
     * @Route("/admin/categories/create", name="categories_create")
     */
    public function createCategorie(Request $request): Response
    {
        $categorie = new Categories;
        $form = $this->createForm(CategoriesType::class, $categorie);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('form');
    }

        return $this->render('form/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
