<?php

namespace App\Controller;

use App\Entity\Limite;
use App\Form\LimiteType;
use App\Form\UpdateLimiteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LimiteController extends AbstractController
{

    /**
     * @Route("/admin/limite", name="limite")
     */
    public function index(): Response
    {
        $limit = $this->getDoctrine()->getRepository(Limite::class)->findAll();
        return $this->render('limite/crudlimite.html.twig', array('limits' => $limit));
    }

    /**
     * @Route("/admin/ajouter/limite", name="ajout_limite")
     */

    public function ajouterLimite(Request $request): Response
    {
        $limit = new Limite();
        $form = $this->createForm(LimiteType::class, $limit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($limit);
            $em->flush();

            return $this->redirectToRoute('limite');
        }
        return $this->render('limite/createlimite.html.twig', [
            'form' => $form->createView(), 'limits' => $limit]);
    }

    /**
     * @Route("/admin/limite/{id}", name="read_limit")
     */

    public function showLimite(int $id): Response
    {
        $limit = $this->getDoctrine()
            ->getRepository(Limite::class)
            ->find($id);

        if(!$limit) {
            throw $this->createNotFoundException(
                "Aucun limite existe avec l'id ".$id
            );
        }
        return new Response("Nombre de limite est: ".$limit->getAttScolarite().' attestation de scolarite '.$limit->getConvStage(). ' convention de stage'.' et '.$limit->getRelNote(). ' releve de note');
    }

    /**
     * @Route("/admin/modifier/limite/{id}", name="modifier_limit")
     */

    public function modifierLimit(Request $request, $id): Response
    {
        $limit = new Limite();
        $limit = $this->getDoctrine()->getRepository(Limite::class)->find($id);
        $form = $this->createForm(UpdateLimiteType::class, $limit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $limit = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($limit);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }
        return $this->render('limite/updatelimite.html.twig', [
            'form' => $form->createView(), 'limits' => $limit,
        ]);
    }

}
