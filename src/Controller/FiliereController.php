<?php

namespace App\Controller;

use App\Entity\Filiere;

use App\Form\FiliereType;
use App\Form\UpdateFiliereType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiliereController extends AbstractController
{
    /**
     * @Route("/admin/filiere", name="filiere")
     */
    public function index(): Response
    {
        $filiere = $this->getDoctrine()->getRepository(Filiere::class)->findAll();
        return $this->render('filiere/crudfiliere.html.twig', array('filieres' => $filiere));
    }

    /**
     * @Route ("/admin/filiere/ajouter", name="ajouter_filiere")
     */
    public function AjouterFiliere(Request $request): Response
    {
        $filiere = new Filiere();
        $form = $this->createForm(FiliereType::class, $filiere);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($filiere);
            $em->flush();

            return $this->redirectToRoute('filiere');
        }
        return $this->render('filiere/createfiliere.html.twig', [
            'form' => $form->createView(), 'filieres' => $filiere]);
    }
    /**
     * @Route("admin/filiere/{id}", name="read_filiere")
     */

    public function showFiliere(int $id): Response
    {
        $filiere = $this->getDoctrine()
            ->getRepository(Filiere::class)
            ->find($id);

        if(!$filiere) {
            throw $this->createNotFoundException(
                "Aucune Filière existe avec l'id ".$id
            );
        }
        return new Response("libellé de la filière est: ".$filiere->getLibelle());
    }

    /**
     * @Route("/admin/modifier/filiere/{id}", name="modifier_filiere")
     */

    public function modifierFiliere(Request $request, $id): Response
    {
        $filiere = new Filiere();
        $filiere = $this->getDoctrine()->getRepository(Filiere::class)->find($id);
        $form = $this->createForm(UpdateFiliereType::class, $filiere);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $filiere = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($filiere);
            $em->flush();

            return $this->redirectToRoute('filiere');
        }
        return $this->render('filiere/updatfiliere.html.twig', [
            'form' => $form->createView(), 'filieres' => $filiere,
        ]);
    }
    /**
     * @Route ("/admin/filiere/delete/{id}")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $filiere = $entityManager->getRepository(Filiere::class)->find($id);

        if(!$filiere) {
            throw $this->createNotFoundException(
                'Aucune Filière existe avec id '.$id
            );
        }

        $entityManager->remove($filiere);
        $entityManager->flush();

        return new Response("La filière ".$filiere->getLibelle()." a été supprimé");
    }
}
