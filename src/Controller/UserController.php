<?php

namespace App\Controller;

use App\Entity\Etudiant;
use App\Entity\Certificats;
use App\Entity\Limite;
use App\Entity\Notification;
use App\Entity\User;
use App\Form\CertificatsType;
use App\Form\UpdateUserType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="user")
     */
    public function index(): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/cruduser.html.twig', array('users' => $user));
    }

    /**
     * @Route("/admin/user/{id}", name="read_user")
     */

    public function showUser(int $id): Response
    {
        $user = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($id);

        if(!$user) {
            throw $this->createNotFoundException(
                "Aucun utilisateur existe avec l'id ".$id
            );
        }
        return new Response("l'utilisateur ".$user->getId()." est liee avec l'etudiant ".$user->getEtudiant());
    }

    /**
     * @Route("/admin/modifier/user/{id}", name="modifier_user")
     */

    public function modifierUser(Request $request, $id, Security $security): Response
    {
        $user = new User($security);
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $form = $this->createForm(UpdateUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_home');
        }
        return $this->render('user/updateuser.html.twig', [
            'form' => $form->createView(), 'users' => $user,
        ]);
    }


    /**
     * @Route("/admin/user/delete/{id}")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found with id '.$id
            );
        }

        $entityManager->remove($user);
        $entityManager->flush();

        return new Response("l'utilisateur ".$user->getId()." est liee avec l'etudiant ".$user->getEtudiant().' a ete supprime');
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
        $entityManager = $this->getDoctrine()->getManager();
        $demande = $this->getDoctrine()
            ->getRepository(User::class)
            ->mesdemandes((string)$id);
        $certificat = new Certificats;
        $form = $this->createForm(CertificatsType::class, $certificat);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $categories = $form["categories"]->getData();
            $check = $entityManager->getRepository(Limite::class)->findOneBy(array('user'=> $id));
            if ($categories == 'attestation de scolarité'){
                $test = $check->getAttScolarite();
                print($test);
                if ($test == 0)
                {
                    throw $this->createNotFoundException(
                        'vous ne pouvez plus demander de certificat'
                    );
                }
                else {
                    $this->getDoctrine()
                        ->getRepository(Limite::class)
                        ->scolarite($id);
                }
            }
            if ($categories == 'relevé de note') {
                $test = $check->getRelNote();
                if ($test == 0)
                {
                    throw $this->createNotFoundException(
                        'vous ne pouvez plus demander de certificat'
                    );
                }
                else {
                    $this->getDoctrine()
                        ->getRepository(Limite::class)
                        ->note($id);
                }
            }
            if ($categories == 'certificats de stage'){
                $test = $check->getConvStage();
                if ($test === 0)
                {
                    throw $this->createNotFoundException(
                        'vous ne pouvez plus demander de certificat'
                    );
                }
                else {
                    $this->getDoctrine()
                        ->getRepository(Limite::class)
                        ->stage($id);
                }
            }

            $certificat->setUser($this->getUser());
            $certificat->setStatus('en cours');

            $entityManager->persist($certificat);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
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
        $terminer = $this->getDoctrine()
                ->getRepository(User::class)
                ->touteslesdemandes();
        return $this->render('user/demande.html.twig', ['demandes' => $demande,'certificats' => $terminer]);
    }
    /**
     * @Route("/admin/certificat/pdfcreate/{id}", name="pdf_create")
     */
    public function pdf(int $id): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $dompdf = new Dompdf($pdfOptions);
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

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $output = $dompdf->output();

        $publicDirectory = $this->getParameter('kernel.project_dir') . '/pdf';
        $now = new \DateTime('now');
        $today = $now->format('Y-m-d');

        $fs=new Filesystem();
        $fs->mkdir($publicDirectory.'/'. $today);
        $directory = $publicDirectory.'/'. $today;
        $userid = $this->getUser();

        $pdfFilepath = $directory. '/'. $userid.' - '.$categories.'.pdf';
        file_put_contents($pdfFilepath, $output);
        $this->getDoctrine()
            ->getRepository(User::class)
            ->active($id,$pdfFilepath);

        $entityManager = $this->getDoctrine()->getManager();

        $notification = new Notification();
        $cert = $this->getDoctrine()->getRepository(Certificats::class)->find($id);
        $userid = $cert->getUser();
        $notification->setUser($userid);
        $notification->setMessage('votre '.$categories.' a ete valide avec succes le '.$today);

        $entityManager->persist($notification);
        $entityManager->flush();

        return new Response("The PDF file has been succesfully generated !");
    }
    /**
     * @Route("/admin/certificat/rejeter/{id}", name="rejeter")
     */
    public function rejeter(int $id): Response
    {
        $cert = $this->getDoctrine()->getRepository(Certificats::class)->find($id);
        $userid = $cert->getUser();
        $this->getDoctrine()
            ->getRepository(User::class)
            ->rejeter($id,$userid);
        $categories = $cert->getCategories();
        $now = new \DateTime('now');
        $today = $now->format('Y-m-d');
        $entityManager = $this->getDoctrine()->getManager();

        $notification = new Notification();
        $notification->setUser($userid);
        $notification->setMessage('votre '.$categories.' a ete rejete le '.$today);

        $entityManager->persist($notification);
        $entityManager->flush();
        return new Response("la demande a ete rejete");
    }
    /**
     * @Route("/certificat/{id}", name="showpdf")
     */
    public function showpdf(int $id){
        $entityManager = $this->getDoctrine()->getManager();
        $pdf = $entityManager->getRepository(Certificats::class)->find($id);
        $url = $pdf->getPdfpath();
        return new BinaryFileResponse($url);

    }
}
