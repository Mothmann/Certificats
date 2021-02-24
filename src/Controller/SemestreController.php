<?php

namespace App\Controller;

use App\Entity\Semestre;
use App\Form\SemestreType;
use App\Form\UpdateSemestreType;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SemestreController extends AbstractController
{
    /**
     * @Route("/admin/semestre", name="semestre")
     */
    public function index(): Response
    {
        $semestre = $this->getDoctrine()->getRepository(Semestre::class)->findAll();
        return $this->render('semestre/crudsemestre.html.twig', array('semestres' => $semestre));
    }
    /**
     * @Route ("/admin/semestre/ajouter", name="ajouter_semestre")
     */
    public function AjouterSemestre(Request $request): Response
    {
        $semestre = new Semestre();
        $form = $this->createForm(SemestreType::class, $semestre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($semestre);
            $em->flush();

            return $this->redirectToRoute('semestre');
        }
        return $this->render('semestre/createsemestre.html.twig', [
            'form' => $form->createView(), 'semestres' => $semestre]);
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
     * @Route("/admin/modifier/semestre/{id}", name="modifier_semestre")
     */

    public function modifierSemestre(Request $request, $id): Response
    {
        $semestre = new Semestre();
        $semestre = $this->getDoctrine()->getRepository(Semestre::class)->find($id);
        $form = $this->createForm(UpdateSemestreType::class, $semestre);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $semestre = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($semestre);
            $em->flush();

            return $this->redirectToRoute('semestre');
        }
        return $this->render('semestre/updatesemestre.html.twig', [
            'form' => $form->createView(), 'semestres' => $semestre,
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
