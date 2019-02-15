<?php
/**
 * Created by PhpStorm.
 * User: Finelia
 * Date: 13/02/2019
 * Time: 09:22
 */

namespace App\Controller\Front;


use App\Entity\Notifications;
use App\Repository\NotificationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{

    /**
     * @Route("/notif", name="notif_user", methods={"GET"})
     */
    public function getUserNotification( NotificationsRepository $notifRep ){

        if( !empty( $this->getUser() ) ){

            $notifications = $notifRep->getAllNotificationFromUser( $this->getUser() );
            //dump( $notifications ); die;
            if( !empty( $notifications ) ){
                $numberOfNotifs = count( $notifications );
            }
            else{
                $numberOfNotifs = 0;
            }

            $content_array = array();
            foreach ($notifications as $notif => $value ){
                $content_array[$notif][] = $value->getId();
                $content_array[$notif][] = $value->getContent();
            }

            $return = [ 'counter' => $numberOfNotifs,
                'notifs' => $content_array ];
            return new JsonResponse( $return );

        }
    }

    /**
     * @Route("/notif_dismiss", name="notif_user_dismiss", methods={"POST"})
     */
    public function dismissNotification( Request $request , NotificationsRepository $notificationsRepository ){

        $data = $request->get('id');


        $notification = $this->getDoctrine()
            ->getRepository( Notifications::class )
            ->find( $data );

        //$notification = $notificationsRepository->getOneNotification( $data );

        $notification->setIsSeen( true );

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return true;

    }


}