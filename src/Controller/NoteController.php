<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use App\Form\UpdateNoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    /**
     * @Route("/admin/note", name="note")
     */
    public function index(): Response
    {
        $note = $this->getDoctrine()->getRepository(Note::class)->findAll();
        return $this->render('note/crudnote.html.twig', array('notes' => $note));
    }

    /**
     * @Route("/admin/ajouter/note", name="ajout_note")
     */

    public function ajouterNote(Request $request): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();

            return $this->redirectToRoute('note');
        }
        return $this->render('note/createnote.html.twig', [
            'form' => $form->createView(), 'notes' => $note]);
    }

    /**
     * @Route("/admin/note/{id}", name="read_note")
     */

    public function showNote(int $id): Response
    {
        $note = $this->getDoctrine()
            ->getRepository(Note::class)
            ->find($id);

        if(!$note) {
            throw $this->createNotFoundException(
                "Aucune note existe avec l'id ".$id
            );
        }
        return new Response("la note de l'etudiant ".$note->getUser().' dans le module:'.$note->getModule().' est '.$note->getNote());
    }

    /**
     * @Route("/admin/modifier/note/{id}", name="modifier_note")
     */

    public function modifierNote(Request $request, $id): Response
    {
        $note = new Note();
        $note = $this->getDoctrine()->getRepository(Note::class)->find($id);
        $form = $this->createForm(UpdateNoteType::class, $note);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $note = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }
        return $this->render('note/updatenote.html.twig', [
            'form' => $form->createView(), 'notes' => $note,
        ]);
    }


    /**
     * @Route("/admin/note/delete/{id}")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $note = $entityManager->getRepository(Note::class)->find($id);

        if (!$note) {
            throw $this->createNotFoundException(
                'No note found with id '.$id
            );
        }

        $entityManager->remove($note);
        $entityManager->flush();

        return new Response("la note de l'etudiant ".$note->getUser().' dans le module:'.$note->getModule().'  a été supprimé');
    }
}
