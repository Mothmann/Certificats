<?php

namespace App\Controller;

use App\Entity\Etudiant;

use App\Form\EtudiantType;
use App\Form\UpdateEtudiantType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{

    /**
     * @Route("/admin/etudiant", name="etudiant")
     */
    public function index(): Response
    {
        $etudiant = $this->getDoctrine()->getRepository(Etudiant::class)->findAll();
        return $this->render('etudiant/crudetudiant.html.twig', array('etudiants' => $etudiant));
    }

    /**
     * @Route("/admin/ajouter/etudiant", name="ajout_etudiant")
     */

    public function ajouterEtudiant(Request $request): Response
    {
        $etudiant = new Etudiant();
        $form = $this->createForm(EtudiantType::class, $etudiant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($etudiant);
            $em->flush();

            return $this->redirectToRoute('etudiant');
        }
        return $this->render('etudiant/createtudiant.html.twig', [
            'form' => $form->createView(), 'etudiants' => $etudiant]);
    }

    /**
     * @Route("/admin/etudiant/{id}", name="read_etudiant")
     */

    public function showEtudiant(int $id): Response
    {
        $etudiant = $this->getDoctrine()
            ->getRepository(Etudiant::class)
            ->find($id);

        if(!$etudiant) {
            throw $this->createNotFoundException(
                "Aucun étudiant existe avec l'id ".$id
            );
        }
        return new Response("Nom de l'étudiant est: ".$etudiant->getNom().' '.$etudiant->getPrenom());
    }

    /**
     * @Route("/admin/modifier/etudiant/{id}", name="modifier_etudiant")
     */

    public function modifierEtudiant(Request $request, $id): Response
    {
        $etudiant = new Etudiant();
        $etudiant = $this->getDoctrine()->getRepository(Etudiant::class)->find($id);
        $form = $this->createForm(UpdateEtudiantType::class, $etudiant);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $etudiant = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($etudiant);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }
        return $this->render('etudiant/updatetudiant.html.twig', [
            'form' => $form->createView(), 'etudiants' => $etudiant,
        ]);
    }


    /**
     * @Route("/admin/etudiant/delete/{id}")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $etudiant = $entityManager->getRepository(Etudiant::class)->find($id);

        if (!$etudiant) {
            throw $this->createNotFoundException(
                'No etudiant found with id '.$id
            );
        }

        $entityManager->remove($etudiant);
        $entityManager->flush();

       return new Response("L'étudiant ".$etudiant->getNom().' '.$etudiant->getPrenom().' a été supprimé');
    }
}
