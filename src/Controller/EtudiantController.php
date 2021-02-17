<?php

namespace App\Controller;

use App\Entity\Etudiant;

use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtudiantController extends AbstractController
{
    /**
     * @Route("/admin/etudiant", name="etudiant")
     */
    public function index(): Response
    {
        return $this->render('etudiant/index.html.twig', [
            'controller_name' => 'EtudiantController',
        ]);
    }
    /**
     * @Route("/admin/etudiant/create", name="create_etudiant")
     */
    public function createEtudiant(): Response
    {

        $date_naissance= "19-06-2000";
        $date_inscription= "01-09-2018";
        $date_1ere_inscription= "01-09-2017";
        $entityManager = $this->getDoctrine()->getManager();

        $etudiant = new Etudiant();
        $filiere = $entityManager->find('App:Filiere',1);

        $etudiant->setCodeApogee('235313');
        $etudiant->setNom('Lahlou');
        $etudiant->setPrenom('Othman');
        $etudiant->setCne('DQ1343567');
        $etudiant->setCin('BK852134');
        $etudiant->setDateNaissance(\DateTime::createFromFormat('d-m-Y', $date_naissance));
        $etudiant->setVilleNaissance("Casablanca");
        $etudiant->setPaysNaissance("Maroc");
        $etudiant->setSexe("M");
        $etudiant->setAddresse("Rue tacharouq Quartier ghandi immeuble 17 etage 4");
        $etudiant->setAnnee1ereInscriptionUniversite(\DateTime::createFromFormat('d-m-Y',$date_inscription));
        $etudiant->setAnnee1ereInscriptionEnseignementSuperieur(\DateTime::createFromFormat('d-m-Y',$date_1ere_inscription));
        $etudiant->setAnnee1ereInscriptionUniversiteMarocaine(\DateTime::createFromFormat('d-m-Y',$date_1ere_inscription));
        $etudiant->setCodeBac("DC7543");
        $etudiant->setSerieBac("PC2018");
        $etudiant->setFiliere($filiere);

        $entityManager->persist($etudiant);

        $entityManager->flush();

        return new Response('Nouveau Etudiant a été créé avec id '.$etudiant->getId());
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
     * @Route("/admin/etudiant/update/{id}")
     */
    public function update(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $etudiant = $entityManager->getRepository(Etudiant::class)->find($id);

        if (!$etudiant) {
            throw $this->createNotFoundException(
                'Aucun Etudiant éxiste avec Id '.$id
            );
        }

        $etudiant->setNom('Belhad');
        $etudiant->setPrenom('Yassine');
        $entityManager->flush();

        return $this->redirectToRoute('read_etudiant', [
            'id' => $etudiant->getId()
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
