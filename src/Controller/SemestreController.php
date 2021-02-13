<?php

namespace App\Controller;

use App\Entity\Semestre;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SemestreController extends AbstractController
{
    /**
     * @Route("/admin/semestre", name="semestre")
     */
    public function index(): Response
    {
        return $this->render('semestre/index.html.twig', [
            'controller_name' => 'SemestreController',
        ]);
    }
    /**
     * @Route("/admin/semestre/create", name="create_semestre")
     */
    public function createSemetre(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $semestre = new Semestre();
        $semestre->setLibelle('S1');

        $entityManager->persist($semestre);

        $entityManager->flush();

        return new Response('Nouveau semèstre a été créé avec id '.$semestre->getId());
    }
    /**
     * @Route("admin/semestre/{id}", name="read_semestre")
     */

    public function showSemestre(int $id): Response
    {
        $semestre = $this->getDoctrine()
            ->getRepository(Semestre::class)
            ->find($id);

        if(!$semestre) {
            throw $this->createNotFoundException(
                "Aucun semestre existe avec l'id ".$id
            );
        }
        return new Response("libellé du semestre est: ".$semestre->getLibelle());
    }

    /**
     * @Route("/admin/semestre/update/{id}")
     */
    public function update(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $semestre = $entityManager->getRepository(Semestre::class)->find($id);

        if (!$semestre) {
            throw $this->createNotFoundException(
                'Aucun semèstre existe avec id '.$id
            );
        }

        $semestre->setLibelle("S2");
        $entityManager->flush();

        return $this->redirectToRoute('read_semestre', [
            'id' => $semestre->getId()
        ]);
    }
    /**
     * @Route ("/admin/semestre/delete/{id}")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $semestre = $entityManager->getRepository(Semestre::class)->find($id);

        if(!$semestre) {
            throw $this->createNotFoundException(
                'Aucun semèstre existe avec id '.$id
            );
        }

        $entityManager->remove($semestre);
        $entityManager->flush();

        return new Response("Le semèstre ".$semestre->getLibelle()." a été supprimé");
    }

}
