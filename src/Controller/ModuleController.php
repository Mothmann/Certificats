<?php

namespace App\Controller;

use App\Entity\Module;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ModuleType;
use App\Form\UpdateModuleType;


class ModuleController extends AbstractController
{
    /**
     * @Route("/admin/module", name="module")
     */
    public function index(): Response
    {
        $module = $this->getDoctrine()->getRepository(Module::class)->findAll();
        return $this->render('module/crudmodule.html.twig', array('modules' => $module));
    }

    /**
     * @Route ("/admin/module/ajouter", name="ajouter_module")
     */
    public function AjouterModule(Request $request): Response
    {
        $module = new Module();
        $form = $this->createForm(ModuleType::class, $module);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();

            return $this->redirectToRoute('module');
        }
        return $this->render('module/createmodule.html.twig', [
            'form' => $form->createView(), 'modules' => $module]);
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
     * @Route("/admin/modifier/module/{id}", name="modifier_module")
     */

    public function modifierModule(Request $request, $id): Response
    {
        $module = new Module();
        $module = $this->getDoctrine()->getRepository(Module::class)->find($id);
        $form = $this->createForm(UpdateModuleType::class, $module);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $module = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($module);
            $em->flush();

            return $this->redirectToRoute('module');
        }
        return $this->render('module/updatemodule.html.twig', [
            'form' => $form->createView(), 'modules' => $module,
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
