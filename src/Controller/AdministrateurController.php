<?php

namespace App\Controller;

use App\Entity\Administrateur;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdministrateurController extends AbstractController
{
    /**
     * @Route("/admin/administrateur", name="administrateur")
     */
    public function index(): Response
    {
        return $this->render('administrateur/index.html.twig', [
            'controller_name' => 'AdministrateurController',
        ]);
    }

    /**
     * @Route("/admin/administrateur/create", name="create_admin")
     */
    public function CreateAdmin(): Response
    {
        $date_naissance = "03-04-1963";
        $entityManager = $this->getDoctrine()->getManager();

        $admin = new Administrateur();
        $admin->setNom('Archaoui');
        $admin->setPrenom('Said');
        $admin->setCin('BE354461');
        $admin->setDateNaissance(\DateTime::createFromFormat('d-m-Y', $date_naissance));
        $admin->setVilleNaissance('Casablanca');
        $admin->setPaysNaissance('Maroc');
        $admin->setSexe('M');
        $admin->setAddresse('Rue Banafsaj Immeuble 13 etage 2 apt 4');
        $admin->setGrade('2eme grade');
        $admin->setService('service');
        $admin->setPosteOccupe('directeur');

        $entityManager->persist($admin);

        $entityManager->flush();

        return new Response('Nouveau Administrateur a été créé avec id ' . $admin->getId());
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
     * @Route("/admin/administrateur/update/{id}")
     */
    public function update(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $admin = $entityManager->getRepository(Administrateur::class)->find($id);

        if (!$admin) {
            throw $this->createNotFoundException(
                "Aucun administrateur éxiste avec l' ".$id
            );
        }

        $admin->setNom('Tazi');
        $admin->setPrenom('Ahmed');
        $entityManager->flush();

        return $this->redirectToRoute('read_admin', [
            'id' => $admin->getId()
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
