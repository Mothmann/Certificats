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
     * @Route("/admin/limit", name="limite")
     */
    public function index(): Response
    {
        $limit = $this->getDoctrine()->getRepository(Limite::class)->findAll();
        return $this->render('limit/crudlimit.html.twig', array('limits' => $limit));
    }

    /**
     * @Route("/admin/ajouter/limit", name="ajout_limit")
     */

    public function ajouterLimit(Request $request): Response
    {
        $limit = new Limite();
        $form = $this->createForm(LimiteType::class, $limit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($limit);
            $em->flush();

            return $this->redirectToRoute('limit');
        }
        return $this->render('limit/creatlimit.html.twig', [
            'form' => $form->createView(), 'limits' => $limit]);
    }

    /**
     * @Route("/admin/limit/{id}", name="read_limit")
     */

    public function showLimit(int $id): Response
    {
        $limit = $this->getDoctrine()
            ->getRepository(Limite::class)
            ->find($id);

        if(!$limit) {
            throw $this->createNotFoundException(
                "Aucun limite existe avec l'id ".$id
            );
        }
        return new Response("Nombre de limit est: ".$limit->getAttScolarite().' attestation de scolarite '.$limit->getConvStage(). ' convention de stage'.' et '.$limit->getRelNote(). ' releve de note');
    }

    /**
     * @Route("/admin/modifier/limit/{id}", name="modifier_limit")
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
        return $this->render('limit/updatelimit.html.twig', [
            'form' => $form->createView(), 'limits' => $limit,
        ]);
    }
}
