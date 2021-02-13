<?php

namespace App\Controller;

use App\Entity\Module;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModuleController extends AbstractController
{
    /**
     * @Route("/admin/module", name="module")
     */
    public function index(): Response
    {
        return $this->render('module/index.html.twig', [
            'controller_name' => 'ModuleController',
        ]);
    }

    /**
     * @Route("/admin/module/create", name="create_module")
     */
    public function createModule(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $module = new Module();
        $module->setLibelle('php');
        $module->setListeDeSousModules('php natif-Framework');

        $entityManager->persist($module);

        $entityManager->flush();

        return new Response('Nouveau module a été créé avec id '.$module->getId());
    }

    /**
     * @Route("admin/module/{id}", name="read_module")
     */

    public function showModule(int $id): Response
    {
        $module = $this->getDoctrine()
            ->getRepository(Module::class)
            ->find($id);

        if(!$module) {
            throw $this->createNotFoundException(
                "Aucun Module n'existe avec l'id ".$id
            );
        }
        return new Response("libellé du module est: ".$module->getLibelle());
    }

    /**
     * @Route("/admin/module/update/{id}")
     */
    public function update(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $module = $entityManager->getRepository(Module::class)->find($id);

        if (!$module) {
            throw $this->createNotFoundException(
                'Aucun Module existe avec id '.$id
            );
        }

        $module->setLibelle("UML");
        $module->setListeDeSousModules("digramme de cas d'utilisation - diagramme d'activité");
        $entityManager->flush();

        return $this->redirectToRoute('read_module', [
            'id' => $module->getId()
        ]);
    }
    /**
     * @Route ("/admin/module/delete/{id}")
     */
    public function delete(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $module = $entityManager->getRepository(Module::class)->find($id);

        if(!$module) {
            throw $this->createNotFoundException(
                'Aucun Module existe avec id '.$id
            );
        }

        $entityManager->remove($module);
        $entityManager->flush();

        return new Response("Le module ".$module->getLibelle()." a été supprimé");
    }

}
