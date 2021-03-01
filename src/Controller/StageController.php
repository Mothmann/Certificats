<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Form\StageType;
use App\Form\UpdateStageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StageController extends AbstractController
{
    /**
     * @Route("/admin/stage", name="stage")
     */
    public function index(): Response
    {
        $stage = $this->getDoctrine()->getRepository(Stage::class)->findAll();
        return $this->render('stage/crudstage.html.twig', array('stages' => $stage));
    }

    /**
     * @Route("/admin/ajouter/stage", name="ajout_stage")
     */

    public function ajouterStage(Request $request): Response
    {
        $stage = new Stage();
        $form = $this->createForm(StageType::class, $stage);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();

            return $this->redirectToRoute('stage');
        }
        return $this->render('stage/createstage.html.twig', [
            'form' => $form->createView(), 'stages' => $stage]);
    }

    /**
     * @Route("/admin/stage/{id}", name="read_stage")
     */

    public function showStage(int $id): Response
    {
        $stage = $this->getDoctrine()
            ->getRepository(Stage::class)
            ->find($id);

        if(!$stage) {
            throw $this->createNotFoundException(
                "Aucun stage existe avec l'id ".$id
            );
        }
        return new Response("le stage de l'etudiant id ".$stage->getUser().' le passe chez '.$stage->getEntreprise().' avec le responsable '.$stage->getResponsableDeStage());
    }

    /**
     * @Route("/admin/modifier/stage/{id}", name="modifier_stage")
     */

    public function modifierStage(Request $request, $id): Response
    {
        $stage = new Stage();
        $stage = $this->getDoctrine()->getRepository(Stage::class)->find($id);
        $form = $this->createForm(UpdateStageType::class, $stage);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $stage = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }
        return $this->render('stage/updatestage.html.twig', [
            'form' => $form->createView(), 'stages' => $stage,
        ]);
    }


    /**
     * @Route("/admin/stage/delete/{id}")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $stage = $entityManager->getRepository(Stage::class)->find($id);

        if (!$stage) {
            throw $this->createNotFoundException(
                'No stage found with id '.$id
            );
        }

        $entityManager->remove($stage);
        $entityManager->flush();

        return new Response("le stage de l'etudiant id ".$stage->getUser().' le passe chez '.$stage->getEntreprise().' avec le responsable '.$stage->getResponsableDeStage(). 'a ete supprime');
    }
}
