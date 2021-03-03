<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Certificats;
use App\Entity\Limite;

use App\Entity\Note;
use App\Entity\Stage;
use App\Entity\User;
use App\Form\CertificatsType;
use phpDocumentor\Reflection\Types\This;
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
     * @Route("/profile", name="user_profile")
     */
    public function userProfile(): Response {
        $id = $this->getUser();
        $profile = $this->getDoctrine()->getRepository(User::class)->profile($id);
        return $this->render('user/profile.html.twig',['etudiants'=> $profile]);

    }
    /**
     * @Route("/certificat/create", name="certificat_create")
     */

    public function createCertificats(Request $request): Response
    {
        $id = $this->getUser();
        $demande = $this->getDoctrine()
            ->getRepository(User::class)
            ->mesdemandes((string)$id);
        $certificat = new Certificats;
        $form = $this->createForm(CertificatsType::class, $certificat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categories = $form["categories"]->getData();
            $check = $this->getDoctrine()->getRepository(Limite::class)->GetUserId($id);
            if ($categories == 'attestation de scolarité'){
                $test = $check->getAttScolarite();
                if ($test = 0) {
                    throw $this->createNotFoundException(
                        'vous ne pouvez plus demander de certificat'
                    );
                }
                else {
                    $limit = $this->getDoctrine()
                        ->getRepository(Limite::class)
                        ->scolarite((int)$id);
                }
            }
            if ($categories == 'relevé de note') {
                $test = $check->getAttScolarite();
                if ($test = 0) {
                    throw $this->createNotFoundException(
                        'vous ne pouvez plus demander de certificat'
                    );
                }
                else {
                    $limit = $this->getDoctrine()
                        ->getRepository(Limite::class)
                        ->note((int)$id);
                }
            }
            if ($categories == 'certificats de stage'){
                $test = $check->getAttScolarite();
                if ($test = 0){
                    throw $this->createNotFoundException(
                        'vous ne pouvez plus demander de certificat'
                    );
                }
                else {
                    $limit = $this->getDoctrine()
                        ->getRepository(Limite::class)
                        ->stage((int)$id);
                }
            }

            $certificat->setUser($this->getUser());
            $certificat->setStatus('en cours');

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
    public function pdf(int $id): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $certificat = $this->getDoctrine()->getRepository(Certificats::class)->find($id);
        $categories = $certificat->getCategories();
        if ($categories == 'attestation de scolarité'){
            $etudiants = $this->getDoctrine()
                ->getRepository(Etudiant::class)
                ->certificat($id);
            $html = $this->renderView('user/attestation de scolarité.html.twig', [
                'title' => "Certificat de scolarite",'etudiants' => $etudiants
            ]);
        }
        if ($categories == 'relevé de note'){
            $note = $this->getDoctrine()
                ->getRepository(Certificats::class)
                ->find($id);
            $userid = $note->getUser();
            $nom = $this->getDoctrine()
                ->getRepository(Etudiant::class)
                ->nom($userid);
            $etudiants = $this->getDoctrine()
                ->getRepository(Etudiant::class)
                ->note($userid);
            $html = $this->renderView('user/relevé de note.html.twig', [
                'title' => "Releve de note",'notes' => $etudiants,'noms'=> $nom
            ]);
        }
        if ($categories == 'certificats de stage'){
            $stage = $this->getDoctrine()
                ->getRepository(Certificats::class)
                ->find($id);
            $userid = $stage->getUser();
            $etudiants = $this->getDoctrine()
                ->getRepository(Etudiant::class)
                ->stage($userid);
            $html = $this->renderView('user/certificats de stage.html.twig', [
                'title' => "convention de stage",'stages' => $etudiants
            ]);
        }


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
        $this->getDoctrine()
            ->getRepository(User::class)
            ->active($id);


        // Send some text response
        return new Response("The PDF file has been succesfully generated !");
    }
    /**
     * @Route("/admin/certificat/rejeter/{id}", name="rejeter")
     */
    public function rejeter(int $id): Response
    {
        $this->getDoctrine()
            ->getRepository(User::class)
            ->rejeter($id);
        return new Response("la demande a ete rejete");
    }
}
