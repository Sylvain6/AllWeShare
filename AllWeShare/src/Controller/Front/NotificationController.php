<?php
/**
 * Created by PhpStorm.
 * User: Finelia
 * Date: 13/02/2019
 * Time: 09:22
 */

namespace App\Controller\Front;


use App\Repository\NotificationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

            $return = [ 'result' => $numberOfNotifs ];

            return new JsonResponse( $return );
            //dump( $notifications ); die;
        }
    }


}