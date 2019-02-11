<?php
/**
 * Created by PhpStorm.
 * User: antoine
 * Date: 10/02/2019
 * Time: 18:07
 */

namespace App\Service;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Notifications;

class NotificationService extends AbstractController
{

    public function setNotifications( $sender, $receiver, $content ){

        $notif = new Notifications();

        $notif->setIdSender( $sender );
        $notif->setIdReceiver( $receiver );
        $notif->setContent( $content );
        $notif->setIsSeen( false );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($notif);
        $entityManager->flush();

        return $notif;
    }
}