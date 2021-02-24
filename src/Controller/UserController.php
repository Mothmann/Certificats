<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Certificats;

use App\Entity\User;
use App\Form\CertificatsType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
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
        $id = $this->getUser();
        $demande = $this->getDoctrine()
                ->getRepository(User::class)
                ->mesdemande((string)$id);
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
            'form' => $form->createView(), 'demandes' => $demande
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
     * @Route("/admin/certificat/pdfcreate/{id}", name="pdf_create")
     */
    public function pdf($id): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $id = 6;
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $etudiants = $this->getDoctrine()
            ->getRepository(Etudiant::class)
            ->certificat($id);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('user/dompdf.html.twig', [
            'title' => "Certificat de scolarite",'etudiants' => $etudiants
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();

        // In this case, we want to write the file in the public directory
        $publicDirectory = $this->getParameter('kernel.project_dir') . '/private';
        $now = new \DateTime('now');
        $today = $now->format('Y-m-d');

        $fs=new Filesystem();
        $fs->mkdir($publicDirectory.'/'. $today);
        $directory = $publicDirectory.'/'. $today;
        // e.g /var/www/project/public/mypdf.pdf
        $pdfFilepath = $directory. '/' .'mypdf.pdf';

        // Write file to the desired path
        file_put_contents($pdfFilepath, $output);

        // Send some text response
        return new Response("The PDF file has been succesfully generated !");
    }


}
