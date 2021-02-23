<?php

namespace App\Controller;

use App\Entity\Administrateur;

use App\Form\AdministrateurType;
use App\Form\UpdateAdministrateurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrateurController extends AbstractController
{
    /**
     * @Route("/admin/administrateur", name="administrateur")
     */
    public function index(): Response
    {

        $admin = $this->getDoctrine()->getRepository(Administrateur::class)->findAll();
        return $this->render('administrateur/crudadmin.html.twig', array('admins' => $admin));
    }

    /**
     * @Route ("/admin/administrateur/ajouter", name="ajouter_admin")
     */
    public function AjouterAdmin(Request $request): Response
    {
        $admin = new Administrateur();
        $form = $this->createForm(AdministrateurType::class, $admin);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();

            return $this->redirectToRoute('administrateur');
        }
        return $this->render('administrateur/createadmin.html.twig', [
            'form' => $form->createView(), 'admins' => $admin]);
    }

    /**
     * @Route("/admin/administrateur/{id}", name="read_admin")
     */

    public function readAdmin(int $id): Response
    {
        $admin = $this->getDoctrine()
            ->getRepository(Administrateur::class)
            ->find($id);

        if (!$admin) {
            throw $this->createNotFoundException(
                "Aucun administrateur éxiste avec id ".$id
            );
        }
        return new Response("Nom de l'administrateur est: ".$admin->getNom().' '.$admin->getPrenom());
    }

    /**
     * @Route("/admin/modifier/administrateur/{id}", name="modifier_admin")
     */

    public function modifierAdmin(Request $request, $id): Response
    {
        $admin = new Administrateur();
        $admin = $this->getDoctrine()->getRepository(Administrateur::class)->find($id);
        $form = $this->createForm(UpdateAdministrateurType::class, $admin);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $admin = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($admin);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }
        return $this->render('administrateur/updatadmin.html.twig', [
            'form' => $form->createView(), 'admins' => $admin,
        ]);
    }

    /**
     * @Route("/admin/administrateur/delete/{id}")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $admin = $entityManager->getRepository(Administrateur::class)->find($id);

        if (!$admin) {
            throw $this->createNotFoundException(
                "Aucun administrateur existe avec l' ".$id
            );
        }

        $entityManager->remove($admin);
        $entityManager->flush();

        return new Response("l'admin ".$admin->getNom().' '.$admin->getPrenom().' a été supprimé');
    }



}
