<?php

namespace App\Controller;

use App\Entity\Filiere;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FiliereController extends AbstractController
{
    /**
     * @Route("/admin/filiere", name="filiere")
     */
    public function index(): Response
    {
        return $this->render('filiere/index.html.twig', [
            'controller_name' => 'FiliereController',
        ]);
    }

    /**
     * @Route("/admin/filiere/create", name="create_filiere")
     */
    public function createFiliere(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $filiere = new Filiere();
        $filiere->setLibelle('info');

        $entityManager->persist($filiere);

        $entityManager->flush();

        return new Response('Nouvelle filière a été créé avec id '.$filiere->getId());
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
     * @Route("/admin/filiere/update/{id}")
     */
    public function update(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $filiere = $entityManager->getRepository(Filiere::class)->find($id);

        if (!$filiere) {
            throw $this->createNotFoundException(
                'Aucune Filière existe avec id '.$id
            );
        }

        $filiere->setLibelle("formation");
        $entityManager->flush();

        return $this->redirectToRoute('read_filiere', [
            'id' => $filiere->getId()
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
