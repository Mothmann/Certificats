<?php

namespace App\Controller;

use App\Entity\Certificats;

use App\Form\CertificatsType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/profile, name="user_profile")

    public function userProfile(int $etudiant): Response {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $id = $this->getUser()->getId();
        $etudiant = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($etudiant);

        if ($etudiant == null){
            return $this->redirectToRoute('admin_profile');
        }
        else {
            $query = $em-

        }
        return new Response("nom est ....");

    } */
    /**
     * @Route("/admin/profile/{id}", name="admin_profile")


    public function adminProfile(int $administrateur): Response {
        $id = $this->getUser()->getId();
        $administrateur = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($administrateur);



        return new Response("nom est ....");
    } */
    /**
     * @Route("/certificat/create", name="certificat_create")
     */

    public function createCertificats(Request $request): Response
    {
        $certificat = new Certificats;
        $form = $this->createForm(CertificatsType::class, $certificat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $certificat->addUserId($this->getUser());
            $certificat->setActive(1);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($certificat);
            $entityManager->flush();

            return $this->redirectToRoute('user');
        }
        return $this->render('user/create_certificat.html.twig', [
            'form' => $form->createView(),
        ]);

    }

}
