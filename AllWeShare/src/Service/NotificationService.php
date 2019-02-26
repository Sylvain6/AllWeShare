<?php
/**
 * Created by PhpStorm.
<<<<<<< HEAD
 * User: antoine
 * Date: 10/02/2019
 * Time: 18:07
=======
 * User: Finelia
 * Date: 11/02/2019
 * Time: 15:43
>>>>>>> 340034712aa5eeeae3f063cc5713bdfb9795c038
 */

namespace App\Service;


use App\Entity\Notifications;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NotificationService extends AbstractController
{


    public function setNotification( $id_sender, $id_receiver, $content, $id_feature ){

        $notif = new Notifications();

        $notif->setIdSender( $id_sender );
        $notif->setIdReceiver( $id_receiver );
        $notif->setContent( $content );
        $notif->setIsSeen( false );
        $notif->setIdPost( $id_feature );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist( $notif );
        $entityManager->flush();
    }

}