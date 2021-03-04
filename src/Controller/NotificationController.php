<?php

namespace App\Controller;

use App\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    /**
     * @Route("/notification", name="notification")
     */
    public function index(): Response
    {
        $id = $this->getUser();
        $notif = $this->getDoctrine()->getRepository(Notification::class)->notification($id);
        return $this->render('notification/index.html.twig',[
            'notifications' => $notif]);
    }

}
