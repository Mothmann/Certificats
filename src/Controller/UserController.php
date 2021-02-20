<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Etudiant;
use App\Entity\Certificats;

use App\Entity\User;
use App\Form\CertificatsType;
use phpDocumentor\Reflection\Types\Array_;
use PhpParser\Node\Expr\Cast\Object_;
use PhpParser\Node\Scalar\String_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;



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
            $certificat->setUser($this->getUser());
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
    /**
     * @Route("/admin/certificat/demande", name="demande")
     */
    public function demandes(): Response
    {
        $demande = $this->getDoctrine()
            ->getRepository(User::class)
            ->demande();
        return $this->render('user/demande.html.twig', ['demandes' => $demande]);
    }
    /**
     * @Route("/admin/certificat/pdfcreate", name="pdf_create")
     */
    public function pdf()
    {   $etudiants = $this->getDoctrine()
                ->getRepository(Etudiant::class);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);

        $html = $this->renderView('user/dompdf.html.twig', [
            'title' => "Welcome to our PDF Test",'etudiants' => $etudiants
        ]);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

         $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }


}
